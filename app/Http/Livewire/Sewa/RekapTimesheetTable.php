<?php

namespace App\Http\Livewire\Sewa;

use App\Models\VTimesheetSewa;
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

final class RekapTimesheetTable extends PowerGridComponent
{
    use ActionButton;
    public $d_salesorder_sewa_id;

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
    * @return  \Illuminate\Database\Eloquent\Builder<\App\Models\VTimesheetSewa>|null
    */
    public function datasource(): ?Builder
    {
        return VTimesheetSewa::where('id', $this->d_salesorder_sewa_id);
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
            ->addColumn('tanggal')
            ->addColumn('tanggal_formatted', function(VTimesheetSewa $model) {
                return Carbon::parse($model->tanggal)->format('d/m/Y');
            })
            ->addColumn('nama_driver')
            ->addColumn('jam_awal')
            ->addColumn('jam_awal_formatted', function(VTimesheetSewa $model) {
                return Carbon::parse($model->jam_awal)->format('H:i:s');
            })
            ->addColumn('jam_akhir')
            ->addColumn('jam_akhir_formatted', function(VTimesheetSewa $model) {
                return Carbon::parse($model->jam_akhir)->format('H:i:s');
            })
            ->addColumn('lama', function(VTimesheetSewa $model){
               return date_diff(date_create($model->jam_awal),date_create($model->jam_akhir))->format('%h Jam %i Menit');
            })
            ->addColumn('tanggal_formatted', function(VTimesheetSewa $model) {
                return Carbon::parse($model->tanggal)->format('d/m/Y H:i:s');
            })
            ->addColumn('hm_awal')
            ->addColumn('hm_akhir')
            ->addColumn('istirahat')
            ->addColumn('volume')
            ->addColumn('keterangan')
            ->addColumn('created_at')
            ->addColumn('created_at_formatted', function(VTimesheetSewa $model) {
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
            ->title('Tanggal')
            ->field('tanggal_formatted','tanggal')
            ->makeInputDatePicker()
            ->searchable()
            ->sortable(),

            Column::add()
                ->title('DRIVER')
                ->field('nama_driver')
                ->searchable()
                ->makeInputText()
                ->sortable(),

            Column::add()
                ->title('JAM AWAL')
                ->field('jam_awal_formatted','jam_awal')
                ->makeInputDatePicker()
                ->searchable()
                ->sortable(),

            Column::add()
                ->title('JAM AKHIR')
                ->field('jam_akhir_formatted','jam_akhir')
                ->makeInputDatePicker()
                ->searchable()
                ->sortable(),

            Column::add()   
                ->title('HM AWAL')
                ->field('hm_awal')
                ->searchable()
                ->makeInputText()
                ->sortable(),

            Column::add()   
                ->title('HM AKHIR')
                ->field('hm_akhir')
                ->searchable()
                ->makeInputText()
                ->sortable(),

            Column::add()   
                ->title('LAMA')
                ->field('lama')
                ->searchable()
                ->makeInputRange()
                ->sortable(),

            Column::add()   
                ->title('ISTIRAHAT')
                ->field('istirahat')
                ->searchable()
                ->makeInputRange()
                ->sortable(),

            Column::add()   
                ->title('VOLUME')
                ->field('volume')
                ->searchable()
                ->makeInputRange()
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
     * PowerGrid VTimesheetSewa Action Buttons.
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
               ->route('v-timesheet-sewa.edit', ['v-timesheet-sewa' => 'id']),

           Button::add('destroy')
               ->caption('Delete')
               ->class('bg-red-500 cursor-pointer text-white px-3 py-2 m-1 rounded text-sm')
               ->route('v-timesheet-sewa.destroy', ['v-timesheet-sewa' => 'id'])
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
     * PowerGrid VTimesheetSewa Action Rules.
     *
     * @return array<int, \PowerComponents\LivewirePowerGrid\Rules\RuleActions>
     */

    /*
    public function actionRules(): array
    {
       return [
           
           //Hide button edit for ID 1
            Rule::button('edit')
                ->when(fn($v-timesheet-sewa) => $v-timesheet-sewa->id === 1)
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
     * PowerGrid VTimesheetSewa Update.
     *
     * @param array<string,string> $data
     */

    /*
    public function update(array $data ): bool
    {
       try {
           $updated = VTimesheetSewa::query()
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
