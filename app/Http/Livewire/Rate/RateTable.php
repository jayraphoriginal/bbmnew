<?php

namespace App\Http\Livewire\Rate;

use App\Models\Barang;
use App\Models\JarakTempuh;
use App\Models\Rate;
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

final class RateTable extends PowerGridComponent
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
    * @return  \Illuminate\Database\Eloquent\Builder<\App\Models\Rate>|null
    */
    public function datasource(): ?Builder
    {
        return Rate::join('jarak_tempuhs','rates.jarak_tempuh_id','jarak_tempuhs.id')
            ->select('rates.*','jarak_tempuhs.awal', 'jarak_tempuhs.akhir');
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
            ->addColumn('lokasi_awal')
            ->addColumn('tujuan')
            ->addColumn('estimasi_jarak')
            ->addColumn('awal')
            ->addColumn('akhir');
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
                ->title('LOKASI AWAL')
                ->field('lokasi_awal')
                ->sortable()
                ->searchable()
                ->makeInputText(),

            Column::add()
                ->title('TUJUAN')
                ->field('tujuan')
                ->sortable()
                ->searchable()
                ->makeInputText(),

            Column::add()
                ->title('ESTIMASI JARAK')
                ->field('estimasi_jarak')
                ->sortable()
                ->searchable(),

            Column::add()
                ->title('JARAK AWAL')
                ->field('awal')
                ->sortable()
                ->searchable(),

            Column::add()
                ->title('JARAK AKHIR')
                ->field('akhir')
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
     * PowerGrid Rate Action Buttons.
     *
     * @return array<int, \PowerComponents\LivewirePowerGrid\Button>
     */


    public function actions(): array
    {
        return [
            Button::add('edit')
                ->caption(__('Edit'))
                ->class('bg-indigo-500 cursor-pointer text-white px-3 py-2 m-1 rounded text-sm')
                ->openModal('rate.rate-modal',[
                    'editmode' => 'edit',
                    'rate_id' => 'id'
                ]),


            Button::add('destroy')
                ->caption(__('Delete'))
                ->class('bg-red-500 text-white px-3 py-2 m-1 rounded text-sm')
                ->openModal('delete-modal', [
                    'data_id'                 => 'id',
                    'TableName'               => 'rates',
                    'confirmationTitle'       => 'Delete Rate',
                    'confirmationDescription' => 'apakah yakin ingin hapus rate?',
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
     * PowerGrid Rate Action Rules.
     *
     * @return array<int, \PowerComponents\LivewirePowerGrid\Rules\RuleActions>
     */

    /*
    public function actionRules(): array
    {
       return [

           //Hide button edit for ID 1
            Rule::button('edit')
                ->when(fn($rate) => $rate->id === 1)
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
     * PowerGrid Rate Update.
     *
     * @param array<string,string> $data
     */

    /*
    public function update(array $data ): bool
    {
       try {
           $updated = Rate::query()->findOrFail($data['id'])
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
