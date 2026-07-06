<?php

namespace App\Http\Livewire\Penerimaan;

use App\Models\VPenerimaanpph23;
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

final class PenerimaanPph23Table extends PowerGridComponent
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
    * @return  \Illuminate\Database\Eloquent\Builder<\App\Models\VPenerimaanpph23>|null
    */
    public function datasource(): ?Builder
    {
        return VPenerimaanpph23::query();
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
        ->addColumn('nobukti_potong')
        ->addColumn('nobuktikas')
        ->addColumn('tgl_penerimaan')
        ->addColumn('tgl_penerimaan_formatted', function(VPenerimaanpph23 $model) {
            return Carbon::parse($model->tgl_penerimaan)->format('d/m/Y');
        })
        ->addColumn('noinvoice')
        ->addColumn('nokwitansi')
        ->addColumn('nama_customer')
        ->addColumn('total', function(VPenerimaanpph23 $model) {
            return number_format($model->total,0,'.',',');
        })
        ->addColumn('jumlah', function(VPenerimaanpph23 $model) {
            return number_format($model->jumlah,0,'.',',');
        })
        ->addColumn('sisa_invoice', function(VPenerimaanpph23 $model) {
            return number_format($model->sisa_invoice,0,'.',',');
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
                ->title('NO BUKTI POTONG')
                ->field('nobukti_potong')
                ->searchable()
                ->makeInputText()
                ->sortable(),

            Column::add()
                ->title('NO BUKTI KAS')
                ->field('nobuktikas')
                ->searchable()
                ->makeInputRange()
                ->sortable(),

            Column::add()
                ->title('TGL TERIMA')
                ->field('tgl_penerimaan_formatted','tgl_penerimaan')
                ->searchable()
                ->makeInputDatePicker()
                ->sortable(),

            Column::add()
                ->title('NOINVOICE')
                ->field('noinvoice')
                ->searchable()
                ->makeInputRange()
                ->sortable(),

            Column::add()   
                ->title('CUSTOMER')
                ->field('nama_customer')
                ->searchable()
                ->makeInputText()
                ->sortable(),
            
            Column::add()
                ->title('TOTAL')
                ->field('total')
                ->bodyAttribute('text-right')
                ->searchable()
                ->makeInputRange()
                ->sortable(),

            Column::add()
                ->title('JUMLAH')
                ->field('jumlah')
                ->bodyAttribute('text-right')
                ->searchable()
                ->makeInputRange()
                ->sortable(),

            Column::add()
                ->title('SISA INVOICE')
                ->field('sisa_invoice')
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
     * PowerGrid VPenerimaanpph23 Action Buttons.
     *
     * @return array<int, \PowerComponents\LivewirePowerGrid\Button>
     */

    
    public function actions(): array
    {
       return [
            Button::add('cetak')
            ->caption('<span class="material-icons align-middle text-center">print</span>')
            ->tooltip('Bukti Kas')
            ->class('bg-blue-500 cursor-pointer text-white px-3 py-2 m-1 rounded text-sm')
            ->target('_blank')
            ->method('get')
            ->route("printbuktikaspph23",[
                'id' => 'id'
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
     * PowerGrid VPenerimaanpph23 Action Rules.
     *
     * @return array<int, \PowerComponents\LivewirePowerGrid\Rules\RuleActions>
     */

    /*
    public function actionRules(): array
    {
       return [
           
           //Hide button edit for ID 1
            Rule::button('edit')
                ->when(fn($v-penerimaanpph23) => $v-penerimaanpph23->id === 1)
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
     * PowerGrid VPenerimaanpph23 Update.
     *
     * @param array<string,string> $data
     */

    /*
    public function update(array $data ): bool
    {
       try {
           $updated = VPenerimaanpph23::query()
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
