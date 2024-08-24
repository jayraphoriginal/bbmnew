<?php

namespace App\Http\Livewire\Penjualan;

use App\Models\VSuratJalanHeader;
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

final class SuratJalanTable extends PowerGridComponent
{
    use ActionButton;
    public $m_penjualan_id;

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
        $this->showPerPage();
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
    * @return  \Illuminate\Database\Eloquent\Builder<\App\Models\VSuratJalanHeader>|null
    */
    public function datasource(): ?Builder
    {
        return VSuratJalanHeader::where('m_penjualan_id', $this->m_penjualan_id);
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
            ->addColumn('nosuratjalan')
            ->addColumn('tgl_pengiriman')
            ->addColumn('nama_customer')
            ->addColumn('tujuan')
            ->addColumn('nopol')
            ->addColumn('driver')
            ->addColumn('tgl_pengiriman_formatted', function(VSuratJalanHeader $model) {
                return Carbon::parse($model->tgl_pengiriman)->format('d/m/Y');
            });
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
                ->title('No Surat Jalan')
                ->field('nosuratjalan')
                ->searchable()
                ->makeInputText('nosuratjalan')
                ->sortable(),

            Column::add()
                ->title('Tgl Pengiriman')
                ->field('tgl_pengiriman_formatted')
                ->makeInputDatePicker('tgl_pengiriman')
                ->searchable(),

                Column::add()
                ->title('Nama Customer')
                ->field('nama_customer')
                ->searchable()
                ->makeInputText('nama_customer')
                ->sortable(),
            
                Column::add()
                ->title('Tujuan')
                ->field('tujuan')
                ->searchable()
                ->makeInputText('tujuan')
                ->sortable(),

                Column::add()
                ->title('Nopol')
                ->field('nopol')
                ->searchable()
                ->makeInputText('nopol')
                ->sortable(),
            
                Column::add()
                ->title('Driver')
                ->field('driver')
                ->searchable()
                ->makeInputText('driver')
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
     * PowerGrid VSuratJalanHeader Action Buttons.
     *
     * @return array<int, \PowerComponents\LivewirePowerGrid\Button>
     */

    
    public function actions(): array
    {
       return [
            Button::add('cetak')
            ->caption('<span class="material-icons align-middle text-center">print</span>')
            ->tooltip('cetak')
            ->class('bg-blue-500 cursor-pointer text-white rounded text-sm px-3 py-2')
            ->target('_blank')
            ->method('get')
            ->route("printsj",[
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
     * PowerGrid VSuratJalanHeader Action Rules.
     *
     * @return array<int, \PowerComponents\LivewirePowerGrid\Rules\RuleActions>
     */

    /*
    public function actionRules(): array
    {
       return [
           
           //Hide button edit for ID 1
            Rule::button('edit')
                ->when(fn($v-surat-jalan-header) => $v-surat-jalan-header->id === 1)
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
     * PowerGrid VSuratJalanHeader Update.
     *
     * @param array<string,string> $data
     */

    /*
    public function update(array $data ): bool
    {
       try {
           $updated = VSuratJalanHeader::query()
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
