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

final class SalesorderTable extends PowerGridComponent
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
        ->orderBy('m_salesorders.tgl_so','desc')
        ->select('m_salesorders.*','customers.nama_customer','customers.sub_company')
        ->orderBy('noso','desc');
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

            Button::add('concretepump')
                ->caption('<svg class="h-5 w-5 text-white"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <circle cx="6" cy="18" r="2" />  <circle cx="6" cy="6" r="2" />  <circle cx="18" cy="18" r="2" />  <line x1="6" y1="8" x2="6" y2="16" /><path d="M11 6h5a2 2 0 0 1 2 2v8" /><polyline points="14 9 11 6 14 3" /></svg>')
                ->tooltip('concretepump')
                ->class('bg-green-500 cursor-pointer text-white px-3 py-2 m-1 rounded text-sm')
                ->openModal('penjualan.rekap-concretepump-modal',[
                    'm_salesorder_id' => 'id'
            ]),

            Button::add('rekap')
                ->caption('<span class="material-icons align-middle text-center">confirmation_number</span>')
                ->tooltip('ticket')
                ->class('bg-yellow-500 cursor-pointer text-white rounded text-sm px-3 py-2')
                ->target('_blank')
                ->method('get')
                ->route("rekapticket",[
                    'soid' => 'id'
                ]),

            Button::add('rekaptanggal')
                ->caption('<span class="material-icons align-middle text-center">confirmation_number</span>')
                ->tooltip('ticket per tanggal')
                ->class('bg-teal-500 cursor-pointer text-white rounded text-sm px-3 py-1')
                ->openModal('laporan.laporan-ticket-so',[
                    'so_id' => 'id'
                ]),

            Button::add('rekapall')
                ->caption('<span class="material-icons align-middle text-center">local_activity</span>')
                ->tooltip('ticket all')
                ->class('bg-red-500 cursor-pointer text-white rounded text-sm px-3 py-2')
                ->target('_blank')
                ->method('get')
                ->route("rekapticketall",[
                    'soid' => 'id'
                ]),

            Button::add('cetak')
                ->caption('<span class="material-icons align-middle text-center">print</span>')
                ->tooltip('cetak')
                ->class('bg-blue-500 cursor-pointer text-white rounded text-sm px-3 py-2')
                ->target('_blank')
                ->method('get')
                ->route("printso",[
                    'id' => 'id'
                ]),
            
            Button::add('cetak WO')
                ->caption('<span class="material-icons align-middle text-center">print</span>')
                ->tooltip('cetak WO')
                ->class('bg-red-500 cursor-pointer text-white rounded text-sm px-3 py-2')
                ->openModal('penjualan.tanggal-wo-modal', [
                    'so_id' => 'id',
                ]),

            Button::add('edit')
                ->caption('<svg class="h-5 w-5 text-white" <svg  width="24"  height="24"  viewBox="0 0 24 24"  xmlns="http://www.w3.org/2000/svg"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round">  <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />  <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z" /></svg>')
                ->tooltip('update')
                ->class('bg-indigo-500 cursor-pointer text-white px-3 py-2 m-1 rounded text-sm')
                ->openModal('penjualan.salesorder-modal',[
                    'editmode' => 'edit',
                    'salesorder_id' => 'id'
                ]),

            Button::add('destroy')
                ->caption('<svg class="h-5 w-5 text-white"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round">  <circle cx="12" cy="12" r="10" />  <line x1="15" y1="9" x2="9" y2="15" />  <line x1="9" y1="9" x2="15" y2="15" /></svg>')
                ->tooltip('delete')
                ->class('bg-red-500 text-white px-3 py-2 m-1 rounded text-sm')
                ->openModal('delete-modal', [
                    'data_id'                 => 'id',
                    'TableName'               => 'm_salesorders',
                    'confirmationTitle'       => 'Delete SO',
                    'confirmationDescription' => 'apakah yakin ingin hapus SO?',
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
