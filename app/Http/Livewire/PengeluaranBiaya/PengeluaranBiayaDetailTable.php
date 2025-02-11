<?php

namespace App\Http\Livewire\PengeluaranBiaya;

use App\Models\VTmpPengeluaranBiaya;
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

final class PengeluaranBiayaDetailTable extends PowerGridComponent
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
    * @return  \Illuminate\Database\Eloquent\Builder<\App\Models\TmpPengeluaranBiaya>|null
    */
    public function datasource(): ?Builder
    {
        return VTmpPengeluaranBiaya::where('user_id',Auth::user()->id);
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
            ->addColumn('jenis_pembebanan')
            ->addColumn('m_biaya_id')
            ->addColumn('nama_biaya')
            ->addColumn('beban_id')
            ->addColumn('alken')
            ->addColumn('jumlah')
            ->addColumn('jumlah_formatted',function(VTmpPengeluaranBiaya $model) { 
                return number_format($model->jumlah,2,',','.');
            })
            ->addColumn('created_at_formatted', function(VTmpPengeluaranBiaya $model) { 
                return Carbon::parse($model->created_at)->format('d/m/Y H:i:s');
            })
            ->addColumn('updated_at_formatted', function(VTmpPengeluaranBiaya $model) { 
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
                ->title('BEBAN')
                ->field('jenis_pembebanan')
                ->searchable()
                ->makeInputText(),

                Column::add()
                ->title('DIBEBANKAN DI')
                ->field('alken')
                ->searchable()
                ->makeInputText(),

                Column::add()
                ->title('NAMA BIAYA')
                ->field('nama_biaya')
                ->searchable()
                ->makeInputText(),

            Column::add()
                ->title('JUMLAH')
                ->field('jumlah_formatted', 'jumlah')
                ->searchable()
                ->sortable()
                ->makeInputDatePicker('updated_at'),

            Column::add()
                ->title('KETERANGAN')
                ->field('keterangan')
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
     * PowerGrid TmpPengeluaranBiaya Action Buttons.
     *
     * @return array<int, \PowerComponents\LivewirePowerGrid\Button>
     */

    
    public function actions(): array
    {
       return [
            Button::add('edit')
            ->caption(__('Edit'))
            ->class('bg-indigo-500 cursor-pointer text-white px-3 py-2 m-1 rounded text-sm')
            ->openModal('pengeluaran-biaya.pengeluaran-biaya-detail-modal',[
                'editmode' => 'edit',
                'tmp_id' => 'id'
            ]),

        Button::add('destroy')
            ->caption(__('Delete'))
            ->class('bg-red-500 text-white px-3 py-2 m-1 rounded text-sm')
            ->openModal('delete-modal', [
                'data_id'                 => 'id',
                'TableName'               => 'tmp_pengeluaran_biayas',
                'confirmationTitle'       => 'Delete Detail Pengeluaran Biaya',
                'confirmationDescription' => 'apakah yakin ingin hapus detail biaya?',
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
     * PowerGrid TmpPengeluaranBiaya Action Rules.
     *
     * @return array<int, \PowerComponents\LivewirePowerGrid\Rules\RuleActions>
     */

    /*
    public function actionRules(): array
    {
       return [
           
           //Hide button edit for ID 1
            Rule::button('edit')
                ->when(fn($tmp-pengeluaran-biaya) => $tmp-pengeluaran-biaya->id === 1)
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
     * PowerGrid TmpPengeluaranBiaya Update.
     *
     * @param array<string,string> $data
     */

    /*
    public function update(array $data ): bool
    {
       try {
           $updated = TmpPengeluaranBiaya::query()->findOrFail($data['id'])
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
