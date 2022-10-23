<?php

namespace App\Http\Livewire\Bbm;

use App\Models\TambahanBbm;
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

final class PenambahanBbmTable extends PowerGridComponent
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
    * @return  \Illuminate\Database\Eloquent\Builder<\App\Models\TambahanBbm>|null
    */
    public function datasource(): ?Builder
    {
        return TambahanBbm::select('tambahan_bbms.*','kendaraans.nopol',
        'drivers.nama_driver','bahan_bakars.bahan_bakar')
        ->join('kendaraans','tambahan_bbms.kendaraan_id', 'kendaraans.id')
        ->join('drivers','tambahan_bbms.driver_id', 'drivers.id')
        ->join('bahan_bakars','tambahan_bbms.bahan_bakar_id', 'bahan_bakars.id');
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
            ->addColumn('tanggal_penambahan')
            ->addColumn('tanggal_penambahan_formatted', function(TambahanBbm $model) { 
                return Carbon::parse($model->tanggal_penambahan)->format('d/m/Y');
            })
            ->addColumn('nopol')
            ->addColumn('nama_supplier')
            ->addColumn('nama_driver')
            ->addColumn('bahan_bakar')
            ->addColumn('jumlah')
            ->addColumn('jumlah_formatted', function(TambahanBbm $model) { 
                return number_format($model->jumlah,2,'.',',');
            })
            ->addColumn('keterangan')
            ->addColumn('created_at_formatted', function(TambahanBbm $model) { 
                return Carbon::parse($model->created_at)->format('d/m/Y H:i:s');
            })
            ->addColumn('updated_at_formatted', function(TambahanBbm $model) { 
                return Carbon::parse($model->updated_at)->format('d/m/Y H:i:s');
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
            ->title('TANGGAL')
            ->field('tanggal_penambahan_formatted', 'tanggal_penambahan')
            ->searchable()
            ->sortable()
            ->makeInputDatePicker('tanggal_penambahan'),

            Column::add()
                ->title('KENDARAAN')
                ->field('nopol')
                ->searchable()
                ->sortable()
                ->makeInputText(),

            Column::add()
                ->title('DRIVER')
                ->field('nama_driver')
                ->searchable()
                ->sortable()
                ->makeInputText(),

            Column::add()
                ->title('JUMLAH')
                ->field('jumlah_formatted','jumlah')
                ->sortable(),
                
            Column::add()
                ->title('KETERANGAN')
                ->field('keterangan')
                ->searchable()
                ->sortable()
                ->makeInputText(),
        ]
;
    }

    /*
    |--------------------------------------------------------------------------
    | Actions Method
    |--------------------------------------------------------------------------
    | Enable the method below only if the Routes below are defined in your app.
    |
    */

     /**
     * PowerGrid TambahanBbm Action Buttons.
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
               ->route('tambahan-bbm.edit', ['tambahan-bbm' => 'id']),

           Button::add('destroy')
               ->caption('Delete')
               ->class('bg-red-500 cursor-pointer text-white px-3 py-2 m-1 rounded text-sm')
               ->route('tambahan-bbm.destroy', ['tambahan-bbm' => 'id'])
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
     * PowerGrid TambahanBbm Action Rules.
     *
     * @return array<int, \PowerComponents\LivewirePowerGrid\Rules\RuleActions>
     */

    /*
    public function actionRules(): array
    {
       return [
           
           //Hide button edit for ID 1
            Rule::button('edit')
                ->when(fn($tambahan-bbm) => $tambahan-bbm->id === 1)
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
     * PowerGrid TambahanBbm Update.
     *
     * @param array<string,string> $data
     */

    /*
    public function update(array $data ): bool
    {
       try {
           $updated = TambahanBbm::query()->findOrFail($data['id'])
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
