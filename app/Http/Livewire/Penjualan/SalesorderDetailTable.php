<?php

namespace App\Http\Livewire\Penjualan;

use App\Models\VSalesOrder;
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
use DB;

final class SalesorderDetailTable extends PowerGridComponent
{
    use ActionButton;

    public $m_salesorder_id;

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
            ->showPerPage();
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
    * @return  \Illuminate\Database\Eloquent\Builder<\App\Models\DSalesorder>|null
    */
    public function datasource(): ?Builder
    {  
        return VSalesOrder::where('m_salesorder_id',$this->m_salesorder_id);
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
            ->addColumn('m_salesorder_id')
            ->addColumn('rate_id')
            ->addColumn('tujuan')
            ->addColumn('jarak_tempuh_id')
            ->addColumn('tipe')
            ->addColumn('mutubeton_id')
            ->addColumn('kode_mutu')
            ->addColumn('harga_intax', function(VSalesOrder $model) {
                return number_format($model->harga_intax,2,".",",");
            })
            ->addColumn('estimasi_jarak', function(VSalesOrder $model) {
                return number_format($model->estimasi_jarak,2,".",",");
            })
            ->addColumn('jumlah')
            ->addColumn('sisa')
            ->addColumn('satuan_id')
            ->addColumn('satuan')
            ->addColumn('tgl_awal')
            ->addColumn('tgl_akhir')
            ->addColumn('tgl_awal_formatted', function(VSalesOrder $model) {
                return Carbon::parse($model->tgl_awal)->format('d/m/Y');
            })
            ->addColumn('tgl_akhir_formatted', function(VSalesOrder $model) {
                return Carbon::parse($model->tgl_akhir)->format('d/m/Y');
            })
            ->addColumn('status_detail')
            ->addColumn('user_id')
            ->addColumn('created_at_formatted', function(VSalesOrder $model) {
                return Carbon::parse($model->created_at)->format('d/m/Y H:i:s');
            })
            ->addColumn('updated_at_formatted', function(VSalesOrder $model) {
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
                ->title('ID')
                ->field('id'),

            Column::add()
                ->title('KODE MUTU')
                ->field('kode_mutu')
                ->sortable(),

            Column::add()
                ->title('RATE')
                ->field('tujuan'),

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
                ->title('SATUAN')
                ->field('satuan'),

            Column::add()
                ->title('TGL AWAL')
                ->field('tgl_awal_formatted')
                ->sortable(),

            Column::add()
                ->title('TGL AKHIR')
                ->field('tgl_akhir_formatted')
                ->sortable(),

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
            Button::add('edit')
                ->caption(__('Edit'))
                ->class('bg-indigo-500 cursor-pointer text-white px-3 py-2 m-1 rounded text-sm')
                ->openModal('penjualan.salesorder-detail-modal',[
                    'editmode' => 'edit',
                    'dsalesorder_id' => 'id',
                    'm_salesorder_id' => 'm_salesorder_id'
                ]),


            Button::add('destroy')
                ->caption(__('Delete'))
                ->class('bg-red-500 text-white px-3 py-2 m-1 rounded text-sm')
                ->openModal('delete-modal', [
                    'data_id'                 => 'id',
                    'TableName'               => 'd_salesorders',
                    'confirmationTitle'       => 'Delete Item',
                    'confirmationDescription' => 'apakah yakin ingin hapus item?',
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

    /*
    public function actionRules(): array
    {
       return [

           //Hide button edit for ID 1
            Rule::button('edit')
                ->when(fn($d-salesorder) => $d-salesorder->id === 1)
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
