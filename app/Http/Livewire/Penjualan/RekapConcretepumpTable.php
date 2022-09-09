<?php

namespace App\Http\Livewire\Penjualan;

use App\Models\Concretepump;
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

final class RekapConcretepumpTable extends PowerGridComponent
{
    use ActionButton;

    //Messages informing success/error data is updated.
    public bool $showUpdateMessages = true;

    public $m_salesorder_id;

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
    * @return  \Illuminate\Database\Eloquent\Builder<\App\Models\Concretepump>|null
    */
    public function datasource(): ?Builder
    {
        return Concretepump::join('kendaraans','concretepumps.kendaraan_id','kendaraans.id')
        ->join('drivers','concretepumps.driver_id','drivers.id')
        ->join('jarak_tempuhs','concretepumps.jarak_tempuh_id','jarak_tempuhs.id')
        ->join('rates','concretepumps.rate_id','rates.id')
        ->where('concretepumps.m_salesorder_id', $this->m_salesorder_id)
        ->select('concretepumps.*','kendaraans.nopol','drivers.nama_driver','jarak_tempuhs.awal',
        'jarak_tempuhs.akhir','rates.tujuan','rates.estimasi_jarak');
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
            ->addColumn('kendaraan_id')
            ->addColumn('nopol')
            ->addColumn('driver_id')
            ->addColumn('nama_driver')
            ->addColumn('rate_id')
            ->addColumn('tujuan')
            ->addColumn('jarak_tempuh_id')
            ->addColumn('estimasi_jarak', function(Concretepump $model) {
                return number_format($model->estimasi_jarak,2,'.',',');
            })
            ->addColumn('harga_sewa', function(Concretepump $model) {
                return number_format($model->harga_sewa,2,'.',',');
            })
            ->addColumn('keterangan');
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
                ->title('KENDARAAN')
                ->field('nopol')
                ->sortable(),

            Column::add()
                ->title('DRIVER')
                ->field('nama_driver')
                ->sortable(),

            Column::add()
                ->title('RATE')
                ->field('tujuan'),

            Column::add()
                ->title('Estimasi Jarak')
                ->field('estimasi_jarak'),   

            Column::add()
                ->title('HARGA SEWA')
                ->field('harga_sewa'),

            Column::add()
                ->title('KETERANGAN')
                ->field('keterangan'),

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
     * PowerGrid Concretepump Action Buttons.
     *
     * @return array<int, \PowerComponents\LivewirePowerGrid\Button>
     */


    public function actions(): array
    {
        return [
            Button::add('timesheet')
                ->caption(__('Timesheet'))
                ->class('bg-green-500 cursor-pointer text-white px-3 py-2 m-1 rounded text-sm')
                ->openModal('sewa.timesheet-modal',[
                    'tipe' => 'include mixer',
                    'd_so_id' => 'id'
            ]),

            Button::add('cetak')
            ->caption(__('Cetak'))
            ->class('bg-blue-500 cursor-pointer text-white px-3 py-2 m-1 rounded text-sm')
            ->target('_blank')
            ->method('get')
            ->route("printconcretepump",[
                'id' => 'id'
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
     * PowerGrid Concretepump Action Rules.
     *
     * @return array<int, \PowerComponents\LivewirePowerGrid\Rules\RuleActions>
     */

    /*
    public function actionRules(): array
    {
       return [
           
           //Hide button edit for ID 1
            Rule::button('edit')
                ->when(fn($concretepump) => $concretepump->id === 1)
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
     * PowerGrid Concretepump Update.
     *
     * @param array<string,string> $data
     */

    /*
    public function update(array $data ): bool
    {
       try {
           $updated = Concretepump::query()->findOrFail($data['id'])
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
