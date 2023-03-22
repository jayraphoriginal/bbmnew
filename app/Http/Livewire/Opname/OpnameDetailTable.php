<?php

namespace App\Http\Livewire\Opname;

use App\Models\TmpOpname;
use Illuminate\Support\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridEloquent;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\Traits\ActionButton;
use PowerComponents\LivewirePowerGrid\Rules\Rule;

final class OpnameDetailTable extends PowerGridComponent
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
    * @return  \Illuminate\Database\Eloquent\Builder<\App\Models\TmpOpname>|null
    */
    public function datasource(): ?Builder
    {
        return TmpOpname::join('barangs','tmp_opnames.barang_id','barangs.id')
        ->join('satuans','tmp_opnames.satuan_id','satuans.id')
        ->select('tmp_opnames.*','barangs.nama_barang','satuans.satuan')
        ->where('user_id',Auth::user()->id);
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
        ->addColumn('created_at_formatted', function(TmpOpname $model) { 
            return Carbon::parse($model->created_at)->format('d/m/Y H:i:s');
        })
        ->addColumn('satuan_id')
        ->addColumn('satuan')
        ->addColumn('created_at_formatted', function(TmpOpname $model) { 
            return Carbon::parse($model->created_at)->format('d/m/Y H:i:s');
        })
        ->addColumn('updated_at_formatted', function(TmpOpname $model) { 
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
                ->title('Nama Barang')
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
                ->title('SATUAN')
                ->field('satuan')
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
     * PowerGrid TmpOpname Action Buttons.
     *
     * @return array<int, \PowerComponents\LivewirePowerGrid\Button>
     */

    
    public function actions(): array
    {
        return [
            Button::add('edit')
                ->caption(__('Edit'))
                ->class('bg-indigo-500 cursor-pointer text-white px-3 py-2 m-1 rounded text-sm')
                ->openModal('opname.opname-detail-modal',[
                    'editmode' => 'edit',
                    'tmp_id' => 'id'
                ]),

            Button::add('destroy')
                ->caption(__('Delete'))
                ->class('bg-red-500 text-white px-3 py-2 m-1 rounded text-sm')
                ->openModal('delete-modal', [
                    'data_id'                 => 'id',
                    'TableName'               => 'tmp_opnames',
                    'confirmationTitle'       => 'Delete Detail Opname',
                    'confirmationDescription' => 'apakah yakin ingin hapus detail Opname?',
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
     * PowerGrid TmpOpname Action Rules.
     *
     * @return array<int, \PowerComponents\LivewirePowerGrid\Rules\RuleActions>
     */

    /*
    public function actionRules(): array
    {
       return [
           
           //Hide button edit for ID 1
            Rule::button('edit')
                ->when(fn($tmp-opname) => $tmp-opname->id === 1)
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
     * PowerGrid TmpOpname Update.
     *
     * @param array<string,string> $data
     */

    /*
    public function update(array $data ): bool
    {
       try {
           $updated = TmpOpname::query()->findOrFail($data['id'])
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
