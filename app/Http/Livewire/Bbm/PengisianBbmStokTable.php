<?php

namespace App\Http\Livewire\Bbm;

use App\Models\VPengisianBbmStok;
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

final class PengisianBbmStokTable extends PowerGridComponent
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
    * @return  \Illuminate\Database\Eloquent\Builder<\App\Models\VPengisianBbmStok>|null
    */
    public function datasource(): ?Builder
    {
        return VPengisianBbmStok::query();
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
            ->addColumn('tgl_pengisian')
            ->addColumn('nama_biaya')
            ->addColumn('jenis_pembebanan')
            ->addColumn('alken')
            ->addColumn('nama_barang')
            ->addColumn('jumlah', function(VPengisianBbmStok $model) { 
                return number_format($model->jumlah, 2,',','.');
            })
            ->addColumn('satuan')
            ->addColumn('total', function(VPengisianBbmStok $model) { 
                return number_format($model->total, 2,',','.');
            })
            ->addColumn('keterangan')
            ->addColumn('tgl_pengisian_formatted', function(VPengisianBbmStok $model) { 
                return Carbon::parse($model->tgl_pengisian)->format('d/m/Y');
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
                ->makeInputRange(),

            Column::add()
                ->title('TANGGAL')
                ->field('tgl_pengisian_formatted', 'tgl_pemakaian')
                ->searchable()
                ->sortable()
                ->makeInputDatePicker('created_at'),

            Column::add()
                ->title('BIAYA')
                ->field('nama_biaya')
                ->searchable()
                ->sortable()
                ->makeInputText(),

            Column::add()
                ->title('DIBEBANKAN DI')
                ->field('alken')
                ->searchable()
                ->sortable()
                ->makeInputText(),

            Column::add()
                ->title('NAMA BARANG')
                ->field('nama_barang')
                ->searchable()
                ->sortable()
                ->makeInputText(),

            Column::add()
                ->title('JUMLAH')
                ->field('jumlah')
                ->searchable()
                ->sortable()
                ->makeInputRange(),  

            Column::add()
                ->title('SATUAN')
                ->field('satuan')
                ->searchable()
                ->sortable()
                ->makeInputText(),

            Column::add()
                ->title('TOTAL')
                ->field('total')
                ->searchable()
                ->sortable()
                ->makeInputRange(),  

            Column::add()
                ->title('KETERANGAN')
                ->field('keterangan')
                ->searchable()
                ->sortable()
                ->makeInputText(),
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
     * PowerGrid VPengisianBbmStok Action Buttons.
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
               ->route('v-pengisian-bbm-stok.edit', ['v-pengisian-bbm-stok' => 'id']),

           Button::add('destroy')
               ->caption('Delete')
               ->class('bg-red-500 cursor-pointer text-white px-3 py-2 m-1 rounded text-sm')
               ->route('v-pengisian-bbm-stok.destroy', ['v-pengisian-bbm-stok' => 'id'])
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
     * PowerGrid VPengisianBbmStok Action Rules.
     *
     * @return array<int, \PowerComponents\LivewirePowerGrid\Rules\RuleActions>
     */

    /*
    public function actionRules(): array
    {
       return [
           
           //Hide button edit for ID 1
            Rule::button('edit')
                ->when(fn($v-pengisian-bbm-stok) => $v-pengisian-bbm-stok->id === 1)
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
     * PowerGrid VPengisianBbmStok Update.
     *
     * @param array<string,string> $data
     */

    /*
    public function update(array $data ): bool
    {
       try {
           $updated = VPengisianBbmStok::query()
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