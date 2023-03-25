<?php

namespace App\Http\Livewire\Penerimaan;

use App\Models\VPenerimaan;
use Illuminate\Support\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridEloquent;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\Traits\ActionButton;
use PowerComponents\LivewirePowerGrid\Rules\Rule;

final class WarkatMasukTable extends PowerGridComponent
{
    use ActionButton;

    //Messages informing success/error data is updated.
    public bool $showUpdateMessages = true;

    /*
    |--------------------------------------------------------------------------
    |  Features Setup
    |--------------------------------------------------------------------------
    | Setup Table's general features
    |
    */
    public function setUp(): void
    {
        $this->showCheckBox()
            ->showPerPage()
            ->showSearchInput()
            ->showExportOption('download', ['excel', 'csv']);
    }

    /*
    |--------------------------------------------------------------------------
    |  Datasource
    |--------------------------------------------------------------------------
    | Provides data to your Table using a Model or Collection
    |
    */
    
    /**
    * PowerGrid datasource.
    *
    * @return  \Illuminate\Database\Eloquent\Builder<\App\Models\VPenerimaan>|null
    */
    public function datasource(): ?Builder
    {
        return VPenerimaan::wherenull('tgl_cair')->where(
            function ($query){
                $query->where('tipe','cheque')
                    ->orWhere('tipe','giro');
            });
    }

    /*
    |--------------------------------------------------------------------------
    |  Relationship Search
    |--------------------------------------------------------------------------
    | Configure here relationships to be used by the Search and Table Filters.
    |
    */

    /**
     * Relationship search.
     *
     * @return array<string, array<int, string>>
     */
    public function relationSearch(): array
    {
        return [];
    }

    /*
    |--------------------------------------------------------------------------
    |  Add Column
    |--------------------------------------------------------------------------
    | Make Datasource fields available to be used as columns.
    | You can pass a closure to transform/modify the data.
    |
    */
    public function addColumns(): ?PowerGridEloquent
    {
        return PowerGrid::eloquent()
        ->addColumn('id')
        ->addColumn('nopenerimaan')
        ->addColumn('tgl_bayar')
        ->addColumn('tgl_bayar_formatted', function(VPenerimaan $model) {
            return Carbon::parse($model->tgl_bayar)->format('d/m/Y');
        })
        ->addColumn('jatuh_tempo')
        ->addColumn('jatuh_tempo_formatted', function(VPenerimaan $model) {
            return Carbon::parse($model->jatuh_tempo)->format('d/m/Y');
        })
        ->addColumn('tipe')
        ->addColumn('nowarkat')
        ->addColumn('norek')
        ->addColumn('tgl_cair')
        ->addColumn('tgl_cair_formatted', function(VPenerimaan $model) {
            return Carbon::parse($model->tgl_cair)->format('d/m/Y');
        })
        ->addColumn('nama_customer')
        ->addColumn('jumlah', function(VPenerimaan $model) {
            return number_format($model->jumlah,0,'.',',');
        })
        ->addColumn('sisa', function(VPenerimaan $model) {
            return number_format($model->sisa,0,'.',',');
        })
        ->addColumn('keterangan');
    }

    /*
    |--------------------------------------------------------------------------
    |  Include Columns
    |--------------------------------------------------------------------------
    | Include the columns added columns, making them visible on the Table.
    | Each column can be configured with properties, filters, actions...
    |
    */

     /**
     * PowerGrid Columns.
     *
     * @return array<int, Column>
     */
    public function columns(): array
    {
        return [

            Column::add()
                ->title('NO BAYAR')
                ->field('nopenerimaan')
                ->searchable()
                ->makeInputText()
                ->sortable(),

            Column::add()
                ->title('TGL BAYAR')
                ->field('tgl_bayar_formatted','tgl_bayar')
                ->searchable()
                ->makeInputDatePicker()
                ->sortable(),

            Column::add()   
                ->title('CUSTOMER')
                ->field('nama_customer')
                ->searchable()
                ->makeInputText()
                ->sortable(),

            Column::add()
                ->title('TIPE')
                ->field('tipe')
                ->searchable()
                ->makeInputText()
                ->sortable(),

            Column::add()   
                ->title('NO WARKAT')
                ->field('no_warkat')
                ->searchable()
                ->makeInputText()
                ->sortable(),

            Column::add()   
                ->title('NOREK')
                ->field('norek')
                ->searchable()
                ->makeInputText()
                ->sortable(),

            Column::add()
                ->title('JATUH TEMPO')
                ->field('jatuh_tempo_formatted','jatuh_tempo')
                ->searchable()
                ->makeInputDatePicker()
                ->sortable(),

            Column::add()
                ->title('TGL CAIR')
                ->field('tgl_cair_formatted','tgl_cair')
                ->searchable()
                ->makeInputDatePicker()
                ->sortable(),

            Column::add()
                ->title('JUMLAH')
                ->field('jumlah')
                ->bodyAttribute('text-right')
                ->searchable()
                ->makeInputRange()
                ->sortable(),

            Column::add()
                ->title('SISA')
                ->field('sisa')
                ->bodyAttribute('text-right')
                ->searchable()
                ->makeInputRange()
                ->sortable(),
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Actions Method
    |--------------------------------------------------------------------------
    | Enable the method below only if the Routes below are defined in your app.
    |
    */

     /**
     * PowerGrid VPenerimaan Action Buttons.
     *
     * @return array<int, \PowerComponents\LivewirePowerGrid\Button>
     */

    
    public function actions(): array
    {
        return [
            Button::add('pencairan')
            ->caption('<span class="material-icons align-middle text-center">account_balance_wallet</span>')
            ->tooltip('pencairan warkat')
            ->class('bg-indigo-500 cursor-pointer text-white px-3 py-2 m-1 rounded text-sm')
            ->openModal('penerimaan.pencairan-warkat-masuk',[
                'penerimaan_id' => 'ID'
            ]),
        ];
    }


    /*
    |--------------------------------------------------------------------------
    | Actions Rules
    |--------------------------------------------------------------------------
    | Enable the method below to configure Rules for your Table and Action Buttons.
    |
    */

     /**
     * PowerGrid VPenerimaan Action Rules.
     *
     * @return array<int, \PowerComponents\LivewirePowerGrid\Rules\RuleActions>
     */

    /*
    public function actionRules(): array
    {
       return [
            Rule::Button('pencairan')
            ->when(fn(VPenerimaan $model) => $model->status == 'finish')
            ->hide(),
        ];
    }
    */

    /*
    |--------------------------------------------------------------------------
    | Edit Method
    |--------------------------------------------------------------------------
    | Enable the method below to use editOnClick() or toggleable() methods.
    | Data must be validated and treated (see "Update Data" in PowerGrid doc).
    |
    */

     /**
     * PowerGrid VPenerimaan Update.
     *
     * @param array<string,string> $data
     */

    /*
    public function update(array $data ): bool
    {
       try {
           $updated = VPenerimaan::query()
                ->update([
                    $data['field'] => $data['value'],
                ]);
       } catch (QueryException $exception) {
           $updated = false;
       }
       return $updated;
    }

    public function updateMessages(string $status = 'error', string $field = '_default_message'): string
    {
        $updateMessages = [
            'success'   => [
                '_default_message' => __('Data has been updated successfully!'),
                //'custom_field'   => __('Custom Field updated successfully!'),
            ],
            'error' => [
                '_default_message' => __('Error updating the data.'),
                //'custom_field'   => __('Error updating custom field.'),
            ]
        ];

        $message = ($updateMessages[$status][$field] ?? $updateMessages[$status]['_default_message']);

        return (is_string($message)) ? $message : 'Error!';
    }
    */
}
