<?php

namespace App\Http\Livewire\PengeluaranBiaya;

use App\Models\VPengeluaranBiaya;
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

final class PengeluaranBiayaTable extends PowerGridComponent
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
    * @return  \Illuminate\Database\Eloquent\Builder<\App\Models\VPengeluaranBiaya>|null
    */
    public function datasource(): ?Builder
    {
        return VPengeluaranBiaya::query();
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
            ->addColumn('nama_supplier')
            ->addColumn('nama_biaya')
            ->addColumn('tipe_pembayaran')
            ->addColumn('jenis_ppn')
            ->addColumn('pajaklain')
            ->addColumn('kode_bank')
            ->addColumn('norek')
            ->addColumn('atas_nama')
            ->addColumn('persen_ppn', function (VPengeluaranBiaya $model){
                return number_format($model->persen_ppn,2,".",",");
            })
            ->addColumn('persen_pajaklain', function (VPengeluaranBiaya $model){
                return number_format($model->persen_pajaklain,2,".",",");
            })
            ->addColumn('ppn', function (VPengeluaranBiaya $model){
                return number_format($model->ppn,2,".",",");
            })
            ->addColumn('total', function (VPengeluaranBiaya $model){
                return number_format($model->total,2,".",",");
            })
            ->addColumn('keterangan')
            ->addColumn('created_at')
            ->addColumn('created_at_formatted', function(VPengeluaranBiaya $model) {
                return Carbon::parse($model->created_at)->format('d/m/Y H:i:s');
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
                ->title('ID')
                ->field('id')
                ->searchable()
                ->sortable(),

            Column::add()
                ->title('SUPPLIER')
                ->field('nama_supplier')
                ->searchable()
                ->makeInputText()
                ->sortable(),

                Column::add()
                ->title('BIAYA')
                ->field('nama_biaya')
                ->searchable()
                ->makeInputText()
                ->sortable(),

                Column::add()
                ->title('TIPE PEMBAYARAN')
                ->field('tipe_pembayaran')
                ->searchable()
                ->makeInputText()
                ->sortable(),

                Column::add()
                ->title('PPN')
                ->field('jenis_ppn')
                ->searchable()
                ->makeInputText()
                ->sortable(),

                Column::add()
                ->title('PAJAK LAIN')
                ->field('pajaklain')
                ->searchable()
                ->makeInputText()
                ->sortable(),

                Column::add()
                ->title('BANK')
                ->field('kode_bank')
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
                ->title('ATAS NAMA')
                ->field('atas_nama')
                ->searchable()
                ->makeInputText()
                ->sortable(),

                Column::add()
                ->title('PERSEN PPN')
                ->field('persen_ppn')
                ->searchable()
                ->makeInputText()
                ->sortable(),

                Column::add()
                ->title('PERSEN PAJAK LAIN')
                ->field('persen_pajaklain')
                ->searchable()
                ->makeInputText()
                ->sortable(),

                Column::add()
                ->title('JUMLAH PPN')
                ->field('ppn')
                ->searchable()
                ->makeInputText()
                ->sortable(),

                Column::add()
                ->title('TOTAL')
                ->field('total')
                ->searchable()
                ->makeInputText()
                ->sortable(),

                Column::add()
                ->title('KETERANGAN')
                ->field('keterangan')
                ->searchable()
                ->makeInputText()
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
     * PowerGrid VPengeluaranBiaya Action Buttons.
     *
     * @return array<int, \PowerComponents\LivewirePowerGrid\Button>
     */

    /*
    public function actions(): array
    {
       return [
           Button::add('edit')
               ->caption('Edit')
               ->class('bg-indigo-500 cursor-pointer text-white px-3 py-2.5 m-1 rounded text-sm')
               ->route('v-pengeluaran-biaya.edit', ['v-pengeluaran-biaya' => 'id']),

           Button::add('destroy')
               ->caption('Delete')
               ->class('bg-red-500 cursor-pointer text-white px-3 py-2 m-1 rounded text-sm')
               ->route('v-pengeluaran-biaya.destroy', ['v-pengeluaran-biaya' => 'id'])
               ->method('delete')
        ];
    }
    */

    /*
    |--------------------------------------------------------------------------
    | Actions Rules
    |--------------------------------------------------------------------------
    | Enable the method below to configure Rules for your Table and Action Buttons.
    |
    */

     /**
     * PowerGrid VPengeluaranBiaya Action Rules.
     *
     * @return array<int, \PowerComponents\LivewirePowerGrid\Rules\RuleActions>
     */

    /*
    public function actionRules(): array
    {
       return [
           
           //Hide button edit for ID 1
            Rule::button('edit')
                ->when(fn($v-pengeluaran-biaya) => $v-pengeluaran-biaya->id === 1)
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
     * PowerGrid VPengeluaranBiaya Update.
     *
     * @param array<string,string> $data
     */

    /*
    public function update(array $data ): bool
    {
       try {
           $updated = VPengeluaranBiaya::query()
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
