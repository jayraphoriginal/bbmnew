<?php

namespace App\Http\Livewire\Kendaraan;

use App\Models\Barang;
use App\Models\Kendaraan;
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

final class KendaraanTable extends PowerGridComponent
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
    * @return  \Illuminate\Database\Eloquent\Builder<\App\Models\Kendaraan>|null
    */
    public function datasource(): ?Builder
    {
        return Kendaraan::join('drivers','kendaraans.driver_id','drivers.id')
            ->select('kendaraans.*','drivers.nama_driver');
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
            ->addColumn('nopol')
            ->addColumn('nama_pemilik')
            ->addColumn('alamat')
            ->addColumn('tipe')
            ->addColumn('model')
            ->addColumn('tahun_pembuatan')
            ->addColumn('warnakb')
            ->addColumn('berlaku_sampai_formatted', function(Kendaraan $model) {
                return Carbon::parse($model->berlaku_sampai)->format('d/m/Y');
            })
            ->addColumn('berlaku_kir_formatted', function(Kendaraan $model) {
                return Carbon::parse($model->berlaku_kir)->format('d/m/Y');
            })
            ->addColumn('tgl_perolehan_formatted', function(Kendaraan $model) {
                return Carbon::parse($model->tgl_perolehan)->format('d/m/Y');
            })
            ->addColumn('siu_formatted', function(Kendaraan $model) {
                return Carbon::parse($model->siu)->format('d/m/Y');
            })
            ->addColumn('muatan')
            ->addColumn('loading')
            ->addColumn('driver_id')
            ->addColumn('nama_driver')
            ->addColumn('created_at_formatted', function(Kendaraan $model) {
                return Carbon::parse($model->created_at)->format('d/m/Y H:i:s');
            })
            ->addColumn('updated_at_formatted', function(Kendaraan $model) {
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
                ->title('NOPOL')
                ->field('nopol')
                ->sortable()
                ->searchable()
                ->makeInputText(),

            Column::add()
                ->title('Driver')
                ->field('nama_driver')
                ->makeInputRange(),

            Column::add()
                ->title('NAMA PEMILIK')
                ->field('nama_pemilik')
                ->sortable()
                ->searchable()
                ->makeInputText(),

            Column::add()
                ->title('ALAMAT')
                ->field('alamat')
                ->sortable()
                ->searchable()
                ->makeInputText(),

            Column::add()
                ->title('TIPE')
                ->field('tipe')
                ->sortable()
                ->searchable()
                ->makeInputText(),

            Column::add()
                ->title('MODEL')
                ->field('model')
                ->sortable()
                ->searchable()
                ->makeInputText(),

            Column::add()
                ->title('TAHUN PEMBUATAN')
                ->field('tahun_pembuatan')
                ->sortable()
                ->searchable()
                ->makeInputText(),

            Column::add()
                ->title('WARNAKB')
                ->field('warnakb')
                ->sortable()
                ->searchable()
                ->makeInputText(),

            Column::add()
                ->title('BERLAKU SAMPAI')
                ->field('berlaku_sampai_formatted', 'berlaku_sampai')
                ->searchable()
                ->sortable()
                ->makeInputDatePicker('berlaku_sampai'),

            Column::add()
                ->title('BERLAKU KIR')
                ->field('berlaku_kir_formatted', 'berlaku_kir')
                ->searchable()
                ->sortable()
                ->makeInputDatePicker('berlaku_kir'),

            Column::add()
                ->title('TGL PEROLEHAN')
                ->field('tgl_perolehan_formatted', 'tgl_perolehan')
                ->searchable()
                ->sortable()
                ->makeInputDatePicker('tgl_perolehan'),

            Column::add()
                ->title('SIU')
                ->field('siu_formatted', 'siu')
                ->searchable()
                ->sortable()
                ->makeInputDatePicker('siu'),

            Column::add()
                ->title('MUATAN')
                ->field('muatan')
                ->makeInputRange(),

            Column::add()
                ->title('LOADING')
                ->field('loading')
                ->sortable()
                ->searchable(),



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
     * PowerGrid Kendaraan Action Buttons.
     *
     * @return array<int, \PowerComponents\LivewirePowerGrid\Button>
     */


    public function actions(): array
    {
        return [
            Button::add('edit')
                ->caption(__('Edit'))
                ->class('bg-indigo-500 cursor-pointer text-white px-3 py-2 m-1 rounded text-sm')
                ->openModal('kendaraan.kendaraan-modal',[
                    'editmode' => 'edit',
                    'kendaraan_id' => 'id'
                ]),

            Button::add('destroy')
                ->caption(__('Delete'))
                ->class('bg-red-500 text-white px-3 py-2 m-1 rounded text-sm')
                ->openModal('delete-modal', [
                    'data_id'                 => 'id',
                    'TableName'               => 'kendaraans',
                    'confirmationTitle'       => 'Delete Kendaraan',
                    'confirmationDescription' => 'apakah yakin ingin hapus Kendaraan?',
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
     * PowerGrid Kendaraan Action Rules.
     *
     * @return array<int, \PowerComponents\LivewirePowerGrid\Rules\RuleActions>
     */

    /*
    public function actionRules(): array
    {
       return [

           //Hide button edit for ID 1
            Rule::button('edit')
                ->when(fn($kendaraan) => $kendaraan->id === 1)
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
     * PowerGrid Kendaraan Update.
     *
     * @param array<string,string> $data
     */

    /*
    public function update(array $data ): bool
    {
       try {
           $updated = Kendaraan::query()->findOrFail($data['id'])
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
