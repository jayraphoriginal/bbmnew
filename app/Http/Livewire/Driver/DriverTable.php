<?php

namespace App\Http\Livewire\Driver;

use App\Models\Driver;
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

final class DriverTable extends PowerGridComponent
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
    * @return  \Illuminate\Database\Eloquent\Builder<\App\Models\Driver>|null
    */
    public function datasource(): ?Builder
    {
        return Driver::query();
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
            ->addColumn('nama_driver')
            ->addColumn('tmpt_lahir')
            ->addColumn('tgl_lahir_formatted', function(Driver $model) {
                return Carbon::parse($model->tgl_lahir)->format('d/m/Y');
            })
            ->addColumn('alamat')
            ->addColumn('pendidikan_terakhir')
            ->addColumn('tgl_masuk_formatted', function(Driver $model) {
                return Carbon::parse($model->tgl_masuk)->format('d/m/Y');
            })
            ->addColumn('agama')
            ->addColumn('status')
            ->addColumn('gol_darah')
            ->addColumn('nobpjstk')
            ->addColumn('nobpjskes')
            ->addColumn('notelp')
            ->addColumn('status_kerja')
            ->addColumn('created_at_formatted', function(Driver $model) {
                return Carbon::parse($model->created_at)->format('d/m/Y H:i:s');
            })
            ->addColumn('updated_at_formatted', function(Driver $model) {
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
                ->title('NAMA DRIVER')
                ->field('nama_driver')
                ->sortable()
                ->searchable()
                ->makeInputText(),

            Column::add()
                ->title('TEMPAT LAHIR')
                ->field('tmpt_lahir')
                ->sortable()
                ->searchable()
                ->makeInputText(),

            Column::add()
                ->title('TANGGAL LAHIR')
                ->field('tgl_lahir_formatted', 'tgl_lahir')
                ->searchable()
                ->sortable()
                ->makeInputDatePicker('tgl_lahir'),

            Column::add()
                ->title('ALAMAT')
                ->field('alamat')
                ->sortable()
                ->searchable()
                ->makeInputText(),

            Column::add()
                ->title('PENDIDIKAN TERAKHIR')
                ->field('pendidikan_terakhir')
                ->sortable()
                ->searchable()
                ->makeInputText(),

            Column::add()
                ->title('TANGGAL MASUK')
                ->field('tgl_masuk_formatted', 'tgl_masuk')
                ->searchable()
                ->sortable()
                ->makeInputDatePicker('tgl_masuk'),

            Column::add()
                ->title('AGAMA')
                ->field('agama')
                ->sortable()
                ->searchable()
                ->makeInputText(),

            Column::add()
                ->title('STATUS')
                ->field('status')
                ->sortable()
                ->searchable()
                ->makeInputText(),

            Column::add()
                ->title('GOL DARAH')
                ->field('gol_darah')
                ->sortable()
                ->searchable()
                ->makeInputText(),

            Column::add()
                ->title('NOBPJSTK')
                ->field('nobpjstk')
                ->sortable()
                ->searchable()
                ->makeInputText(),

            Column::add()
                ->title('NOBPJSKES')
                ->field('nobpjskes')
                ->sortable()
                ->searchable()
                ->makeInputText(),

            Column::add()
                ->title('NOTELP')
                ->field('notelp')
                ->sortable()
                ->searchable()
                ->makeInputText(),

            Column::add()
                ->title('STATUS KERJA')
                ->field('status_kerja')
                ->sortable()
                ->searchable()
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
     * PowerGrid Driver Action Buttons.
     *
     * @return array<int, \PowerComponents\LivewirePowerGrid\Button>
     */


    public function actions(): array
    {
        return [
            Button::add('edit')
                ->caption(__('Edit'))
                ->class('bg-indigo-500 cursor-pointer text-white px-3 py-2 m-1 rounded text-sm')
                ->openModal('driver.driver-modal',[
                    'editmode' => 'edit',
                    'driver_id' => 'id'
                ]),


            Button::add('destroy')
                ->caption(__('Delete'))
                ->class('bg-red-500 text-white px-3 py-2 m-1 rounded text-sm')
                ->openModal('delete-modal', [
                    'data_id'                 => 'id',
                    'TableName'               => 'drivers',
                    'confirmationTitle'       => 'Delete Driver',
                    'confirmationDescription' => 'apakah yakin ingin hapus driver?',
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
     * PowerGrid Driver Action Rules.
     *
     * @return array<int, \PowerComponents\LivewirePowerGrid\Rules\RuleActions>
     */

    /*
    public function actionRules(): array
    {
       return [

           //Hide button edit for ID 1
            Rule::button('edit')
                ->when(fn($driver) => $driver->id === 1)
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
     * PowerGrid Driver Update.
     *
     * @param array<string,string> $data
     */

    /*
    public function update(array $data ): bool
    {
       try {
           $updated = Driver::query()->findOrFail($data['id'])
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
