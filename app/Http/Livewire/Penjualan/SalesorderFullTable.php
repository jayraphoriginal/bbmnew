<?php

namespace App\Http\Livewire\Penjualan;

use App\Models\VJumlahSo;
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
use DB;

final class SalesorderFullTable extends PowerGridComponent
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
    */
    public function datasource(): ?Builder
    {
        return VJumlahSo::select(DB::raw('ROW_NUMBER() OVER(ORDER BY tgl_so ASC) AS id'),'V_JumlahSalesorder.*');
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
        ->addColumn('status_detail')
        ->addColumn('m_salesorder_id')
        ->addColumn('noso')
        ->addColumn('nama_customer')
        ->addColumn('tujuan')
        ->addColumn('mutubeton_id')
        ->addColumn('kode_mutu')
        ->addColumn('harga_intax', function(VJumlahSo $model) {
            return number_format($model->harga_intax,2,".",",");
        })
        ->addColumn('estimasi_jarak', function(VJumlahSo $model) {
            return number_format($model->estimasi_jarak,2,".",",");
        })
        ->addColumn('jumlah')
        ->addColumn('sisa')
        ->addColumn('satuan');
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
                ->title('STATUS')
                ->field('status_detail')
                ->searchable()
                ->sortable()
                ->makeInputText(),

            Column::add()
                ->title('NOPO')
                ->field('noso')
                ->searchable()
                ->sortable()
                ->makeInputText(),

            Column::add()
                ->title('CUSTOMER')
                ->field('nama_customer')
                ->searchable()
                ->sortable()
                ->makeInputText(),

            Column::add()
                ->title('KODE MUTU')
                ->field('kode_mutu')
                ->searchable()
                ->sortable()
                ->makeInputText(),

            Column::add()
                ->title('RATE')
                ->field('tujuan')
                ->searchable()
                ->sortable()
                ->makeInputText(),

            Column::add()
                ->title('Estimasi Jarak')
                ->field('estimasi_jarak'),   

            Column::add()
                ->title('HARGA INTAX')
                ->field('harga_intax'),

            Column::add()
                ->title('JUMLAH')
                ->field('jumlah'),

            Column::add()
                ->title('SISA')
                ->field('sisa'),

            Column::add()
                ->title('SATUAN')
                ->field('satuan'),
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
     * PowerGrid DSalesorder Action Buttons.
     *
     * @return array<int, \PowerComponents\LivewirePowerGrid\Button>
     */

    
    public function actions(): array
    {
       return [
            Button::add('Ticket')
            ->caption(__('Ticket'))
            ->class('bg-green-500 cursor-pointer text-white px-3 py-2 m-1 rounded text-sm')
            ->openModal('penjualan.rekap-ticket-modal',[
                'm_salesorder_id' => 'm_salesorder_id',
                'mutubeton_id' => 'mutubeton_id'
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
     * PowerGrid DSalesorder Action Rules.
     *
     * @return array<int, \PowerComponents\LivewirePowerGrid\Rules\RuleActions>
     */

    
    public function actionRules(): array
    {
       return [
           
           //Hide button edit for ID 1
            Rule::Rows('status_detail')
                ->when(fn(VJumlahSo $model) => $model->status_detail == 'Open')
                ->setAttribute('class', 'bg-red-200'),
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Edit Method
    |--------------------------------------------------------------------------
    | Enable the method below to use editOnClick() or toggleable() methods.
    | Data must be validated and treated (see "Update Data" in PowerGrid doc).
    |
    */

     /**
     * PowerGrid DSalesorder Update.
     *
     * @param array<string,string> $data
     */

    /*
    public function update(array $data ): bool
    {
       try {
           $updated = DSalesorder::query()->findOrFail($data['id'])
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
