<?php

namespace App\Http\Livewire\Penjualan;

use App\Models\DPenjualan;
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

final class PenjualanDetailEditTable extends PowerGridComponent
{
    use ActionButton;
    public $m_penjualan_id;

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
        $this->showPerPage();
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
    * @return  \Illuminate\Database\Eloquent\Builder<\App\Models\DPenjualan>|null
    */
    public function datasource(): ?Builder
    {
        return DPenjualan::join('barangs','d_penjualans.barang_id','barangs.id')
        ->join('satuans','d_penjualans.satuan_id','satuans.id')
        ->select('d_penjualans.*','barangs.nama_barang','satuans.satuan')
        ->where('m_penjualan_id',$this->m_penjualan_id);
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
        ->addColumn('barang_id')
        ->addColumn('nama_barang')
        ->addColumn('jumlah')
        ->addColumn('harga_intax')
        ->addColumn('harga_intax_formatted', function(DPenjualan $model) { 
            return number_format($model->harga_intax,2,'.',',');
        })
        ->addColumn('subtotal', function(DPenjualan $model) { 
            return $model->harga_intax * $model->jumlah;
        })
        ->addColumn('subtotal_formatted', function(DPenjualan $model) { 
            return number_format($model->harga_intax * $model->jumlah,2,'.',',');;
        })
        ->addColumn('created_at_formatted', function(DPenjualan $model) { 
            return Carbon::parse($model->created_at)->format('d/m/Y H:i:s');
        })
        ->addColumn('satuan_id')
        ->addColumn('satuan')
        ->addColumn('created_at_formatted', function(DPenjualan $model) { 
            return Carbon::parse($model->created_at)->format('d/m/Y H:i:s');
        })
        ->addColumn('updated_at_formatted', function(DPenjualan $model) { 
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
                ->title('NAMA BARANG')
                ->field('nama_barang')
                ->sortable()
                ->searchable()
                ->makeInputText(),

            Column::add()
                ->title('JUMLAH')
                ->field('jumlah')
                ->bodyAttribute('text-right')
                ->sortable()
                ->searchable(),

            Column::add()
                ->title('HARGA INTAX')
                ->field('harga_intax_formatted','harga_intax')
                ->bodyAttribute('text-right')
                ->sortable()
                ->searchable(),

            Column::add()
                ->title('SATUAN')
                ->field('satuan')
                ->sortable()
                ->searchable(),

            Column::add()
                ->title('SUBTOTAL')
                ->field('subtotal_formatted','subtotal')
                ->bodyAttribute('text-right')
                ->withSum('Total', false, true)
                ->sortable()
                ->searchable(),

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
     * PowerGrid DPenjualan Action Buttons.
     *
     * @return array<int, \PowerComponents\LivewirePowerGrid\Button>
     */

    
    public function actions(): array
    {
        return [
            Button::add('edit')
                ->caption(__('Edit'))
                ->class('bg-indigo-500 cursor-pointer text-white px-3 py-2 m-1 rounded text-sm')
                ->openModal('penjualan.penjualan-detail-edit-modal',[
                    'editmode' => 'edit',
                    'd_penjualan_id' => 'id'
                ]),

            Button::add('destroy')
                ->caption(__('Delete'))
                ->class('bg-red-500 text-white px-3 py-2 m-1 rounded text-sm')
                ->openModal('delete-modal', [
                    'data_id'                 => 'id',
                    'TableName'               => 'd_penjualans',
                    'confirmationTitle'       => 'Delete Detail Penjualan',
                    'confirmationDescription' => 'apakah yakin ingin hapus detail Penjualan?',
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
     * PowerGrid DPenjualan Action Rules.
     *
     * @return array<int, \PowerComponents\LivewirePowerGrid\Rules\RuleActions>
     */

    /*
    public function actionRules(): array
    {
       return [
           
           //Hide button edit for ID 1
            Rule::button('edit')
                ->when(fn($d-penjualan) => $d-penjualan->id === 1)
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
     * PowerGrid DPenjualan Update.
     *
     * @param array<string,string> $data
     */

    /*
    public function update(array $data ): bool
    {
       try {
           $updated = DPenjualan::query()
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
