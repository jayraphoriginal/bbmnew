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
        return Kendaraan::leftjoin('drivers','kendaraans.driver_id','drivers.id')
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
                ->caption('<svg class="h-5 w-5 text-white" <svg  width="24"  height="24"  viewBox="0 0 24 24"  xmlns="http://www.w3.org/2000/svg"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round">  <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />  <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z" /></svg>')
                ->tooltip('update')
                ->class('bg-indigo-500 cursor-pointer text-white px-3 py-2 m-1 rounded text-sm')
                ->openModal('kendaraan.kendaraan-modal',[
                    'editmode' => 'edit',
                    'kendaraan_id' => 'id'
                ]),

            Button::add('destroy')
                ->caption('<svg class="h-5 w-5 text-white"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round">  <circle cx="12" cy="12" r="10" />  <line x1="15" y1="9" x2="9" y2="15" />  <line x1="9" y1="9" x2="15" y2="15" /></svg>')
                ->class('bg-red-500 text-white px-3 py-2 m-1 rounded text-sm')
                ->tooltip('delete')
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
