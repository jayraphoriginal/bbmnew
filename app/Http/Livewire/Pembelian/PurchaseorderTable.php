<?php

namespace App\Http\Livewire\Pembelian;

use App\Models\MPurchaseorder;
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

final class PurchaseorderTable extends PowerGridComponent
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
    * @return  \Illuminate\Database\Eloquent\Builder<\App\Models\MPurchaseorder>|null
    */
    public function datasource(): ?Builder
    {
        return MPurchaseorder::join('suppliers','m_purchaseorders.supplier_id','suppliers.id')
        ->select('m_purchaseorders.*','suppliers.nama_supplier');
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
            ->addColumn('nopo')
            ->addColumn('nofaktur')
            ->addColumn('tgl_masuk_formatted', function(MPurchaseorder $model) { 
                return Carbon::parse($model->tgl_masuk)->format('d/m/Y');
            })
            ->addColumn('jatuh_tempo_formatted', function(MPurchaseorder $model) { 
                return Carbon::parse($model->jatuh_tempo)->format('d/m/Y');
            })
            ->addColumn('nama_supplier')
            ->addColumn('dpp', function(MPurchaseorder $model) { 
                return number_format($model->dpp,2,".",",");
            })
            ->addColumn('tipe')
            ->addColumn('ppn', function(MPurchaseorder $model) { 
                return number_format($model->ppn,2,".",",");
            })
            ->addColumn('total', function(MPurchaseorder $model) { 
                return number_format($model->total,2,".",",");
            })
            ->addColumn('status')
            ->addColumn('pembebanan')
            ->addColumn('jenis_pembebanan')
            ->addColumn('created_at_formatted', function(MPurchaseorder $model) { 
                return Carbon::parse($model->created_at)->format('d/m/Y H:i:s');
            })
            ->addColumn('updated_at_formatted', function(MPurchaseorder $model) { 
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
                ->title('STATUS')
                ->field('status')
                ->searchable()
                ->sortable()
                ->makeInputText(),

            Column::add()
                ->title('NOPO')
                ->field('nopo')
                ->searchable()
                ->sortable()
                ->makeInputText(),
            Column::add()
                ->title('NO FAKTUR')
                ->field('nofaktur')
                ->searchable()
                ->sortable()
                ->makeInputText(),
            Column::add()
                ->title('TIPE')
                ->field('tipe')
                ->searchable()
                ->sortable()
                ->makeInputText(),
            Column::add()
                ->title('TGL MASUK')
                ->field('tgl_masuk')
                ->sortable()
                ->makeInputDatePicker(),
            Column::add()
                ->title('JATUH TEMPO')
                ->field('jatuh_tempo')
                ->sortable()
                ->makeInputDatePicker(),
            Column::add()
                ->title('SUPPLIER')
                ->field('nama_supplier')
                ->searchable()
                ->sortable()
                ->makeInputText(),
            Column::add()
                ->title('DPP')
                ->field('dpp'),
            Column::add()
                ->title('PPN')
                ->field('ppn'),
            Column::add()
                ->title('TOTAL')
                ->field('total'),
            Column::add()
                ->title('PEMBEBANAN')
                ->field('pembebanan')
                ->searchable()
                ->sortable()
                ->makeInputText(),
            Column::add()
                ->title('JENIS PEMBEBANAN')
                ->field('jenis_pembebanan')
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
     * PowerGrid MPurchaseorder Action Buttons.
     *
     * @return array<int, \PowerComponents\LivewirePowerGrid\Button>
     */

    
    public function actions(): array
    {
        return [

            Button::add('cetak')
                ->caption(__('Cetak'))
                ->class('bg-blue-500 cursor-pointer text-white px-3 py-2 m-1 rounded text-sm')
                ->target('_blank')
                ->method('get')
                ->route("printpo",[
                    'id' => 'id'
                ]),

            // Button::add('edit')
            //     ->caption(__('Edit'))
            //     ->class('bg-indigo-500 cursor-pointer text-white px-3 py-2 m-1 rounded text-sm')
            //     ->openModal('pembelian.purchaseorder-modal',[
            //         'editmode' => 'edit',
            //         'po_id' => 'id'
            //     ]),

            // Button::add('destroy')
            //     ->caption(__('Delete'))
            //     ->class('bg-red-500 text-white px-3 py-2 m-1 rounded text-sm')
            //     ->openModal('delete-modal', [
            //         'data_id'                 => 'id',
            //         'TableName'               => 'm_purchaseorders',
            //         'confirmationTitle'       => 'Delete Purchase Order',
            //         'confirmationDescription' => 'apakah yakin ingin hapus PO?',
            //     ]),
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
     * PowerGrid MPurchaseorder Action Rules.
     *
     * @return array<int, \PowerComponents\LivewirePowerGrid\Rules\RuleActions>
     */

    
    public function actionRules(): array
    {
        return [
           
            //Hide button edit for ID 1
             Rule::Rows('status')
                 ->when(fn(MPurchaseorder $model) => $model->status == 'Cancel')
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
     * PowerGrid MPurchaseorder Update.
     *
     * @param array<string,string> $data
     */

    /*
    public function update(array $data ): bool
    {
       try {
           $updated = MPurchaseorder::query()->findOrFail($data['id'])
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
