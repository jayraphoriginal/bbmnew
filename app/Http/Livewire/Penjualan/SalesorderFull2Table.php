<?php

namespace App\Http\Livewire\Penjualan;

use App\Models\MSalesorder;
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

final class SalesorderFull2Table extends PowerGridComponent
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
    * @return  \Illuminate\Database\Eloquent\Builder<\App\Models\MSalesorder>|null
    */
    public function datasource(): ?Builder
    {
        return MSalesorder::join('customers','m_salesorders.customer_id','customers.id')
        ->select('m_salesorders.*','customers.nama_customer')->orderBy('tgl_so','desc')->orderBy('noso','desc');
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
            ->addColumn('noso')
            ->addColumn('nopo')
            ->addColumn('tgl_so_formatted', function(MSalesorder $model) {
                return Carbon::parse($model->tgl_so)->format('d/m/Y');
            })
            ->addColumn('marketing')
            ->addColumn('pembayaran')
            ->addColumn('jatuh_tempo_formatted', function(MSalesorder $model) {
                return Carbon::parse($model->jatuh_tempo)->format('d/m/Y');
            })
            ->addColumn('customer_id')
            ->addColumn('nama_customer')
            ->addColumn('sub_company');
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
                ->title('NOPO')
                ->field('noso')
                ->sortable()
                ->searchable()
                ->makeInputText(),

            Column::add()
                ->title('TGL PO')
                ->field('tgl_so_formatted', 'tgl_so')
                ->searchable()
                ->sortable()
                ->makeInputDatePicker('tgl_so'),

            Column::add()
                ->title('CUSTOMER')
                ->field('nama_customer')
                ->searchable()
                ->sortable()
                ->makeInputText(),

            Column::add()
                ->title('SUB COMPANY')
                ->field('sub_company')
                ->searchable()
                ->sortable()
                ->makeInputText(),

            Column::add()
                ->title('NOPO Customer')
                ->field('nopo')
                ->sortable()
                ->searchable()
                ->makeInputText(),

            Column::add()
                ->title('MARKETING')
                ->field('marketing')
                ->sortable()
                ->searchable()
                ->makeInputText(),

            Column::add()
                ->title('PEMBAYARAN')
                ->field('pembayaran')
                ->sortable()
                ->searchable()
                ->makeInputText(),

            Column::add()
                ->title('JATUH TEMPO')
                ->field('jatuh_tempo_formatted', 'jatuh_tempo')
                ->searchable()
                ->sortable()
                ->makeInputDatePicker('jatuh_tempo'),

            Column::add()
                ->title('STATUS PO')
                ->field('status_so')
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
     * PowerGrid MSalesorder Action Buttons.
     *
     * @return array<int, \PowerComponents\LivewirePowerGrid\Button>
     */

    
    public function actions(): array
    {
       return [
            Button::add('Penjualan')
            ->caption('<svg class="h-5 w-5 text-white"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <circle cx="9" cy="19" r="2" />  <circle cx="17" cy="19" r="2" />  <path d="M3 3h2l2 12a3 3 0 0 0 3 2h7a3 3 0 0 0 3 -2l1 -7h-15.2" /></svg>')
            ->tooltip('penjualan')
            ->class('bg-green-500 cursor-pointer text-white px-3 py-2 m-1 rounded text-sm')
            ->openModal('penjualan.rekap-penjualan-modal',[
                'm_salesorder_id' => 'id'
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
     * PowerGrid MSalesorder Action Rules.
     *
     * @return array<int, \PowerComponents\LivewirePowerGrid\Rules\RuleActions>
     */

    /*
    public function actionRules(): array
    {
       return [
           
           //Hide button edit for ID 1
            Rule::button('edit')
                ->when(fn($m-salesorder) => $m-salesorder->id === 1)
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
     * PowerGrid MSalesorder Update.
     *
     * @param array<string,string> $data
     */

    /*
    public function update(array $data ): bool
    {
       try {
           $updated = MSalesorder::query()->findOrFail($data['id'])
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
