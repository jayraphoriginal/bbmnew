<?php

namespace App\Http\Livewire\Penjualan;

use App\Models\MPenjualan;
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

final class PenjualanTable extends PowerGridComponent
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
    * @return  \Illuminate\Database\Eloquent\Builder<\App\Models\MPenjualan>|null
    */
    public function datasource(): ?Builder
    {
        return MPenjualan::join('customers','m_penjualans.customer_id','customers.id')
        ->select('m_penjualans.*','customers.nama_customer')->orderBy('tgl_penjualan','desc')
        ->orderBy('nopenjualan','desc');
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
        ->addColumn('nopenjualan')
        ->addColumn('tgl_penjualan_formatted', function(MPenjualan $model) {
            return Carbon::parse($model->tgl_penjualan)->format('d/m/Y');
        })
        ->addColumn('marketing')
        ->addColumn('pembayaran')
        ->addColumn('jatuh_tempo_formatted', function(MPenjualan $model) {
            return Carbon::parse($model->jatuh_tempo)->format('d/m/Y');
        })
        ->addColumn('customer_id')
        ->addColumn('nama_customer');
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
                ->title('NOPENJUALAN')
                ->field('nopenjualan')
                ->sortable()
                ->searchable()
                ->makeInputText(),

            Column::add()
                ->title('TGL JUAL')
                ->field('tgl_penjualan_formatted', 'tgl_penjualan')
                ->searchable()
                ->sortable()
                ->makeInputDatePicker('tgl_penjualan'),

            Column::add()
                ->title('CUSTOMER')
                ->field('nama_customer')
                ->searchable()
                ->sortable()
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
                ->title('STATUS')
                ->field('status')
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
     * PowerGrid MPenjualan Action Buttons.
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
            ->openModal('penjualan.surat-jalan-component',[
                'm_penjualan_id' => 'id'
            ]),

            Button::add('cetak')
            ->caption('<span class="material-icons align-middle text-center">print</span>')
            ->tooltip('cetak')
            ->class('bg-blue-500 cursor-pointer text-white rounded text-sm px-3 py-2')
            ->target('_blank')
            ->method('get')
            ->route("printsopenjualan",[
                'id' => 'id'
            ]),

            Button::add('cetak')
            ->caption('<span class="material-icons align-middle text-center">local_activity</span>')
            ->tooltip('Rekap Surat Jalan')
            ->class('bg-blue-500 cursor-pointer text-white rounded text-sm px-3 py-2')
            ->target('_blank')
            ->method('get')
            ->route("rekapsuratjalan",[
                'penjualan_id' => 'id'
            ]),

            Button::add('edit')
                ->caption('<svg class="h-5 w-5 text-white" <svg  width="24"  height="24"  viewBox="0 0 24 24"  xmlns="http://www.w3.org/2000/svg"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round">  <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />  <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z" /></svg>')
                ->tooltip('update')
                ->class('bg-indigo-500 cursor-pointer text-white px-3 py-2 m-1 rounded text-sm')
                ->openModal('penjualan.penjualan-modal',[
                    'editmode' => 'edit',
                    'penjualan_id' => 'id'
                ]),

            Button::add('destroy')
                ->caption('<svg class="h-5 w-5 text-white"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round">  <circle cx="12" cy="12" r="10" />  <line x1="15" y1="9" x2="9" y2="15" />  <line x1="9" y1="9" x2="15" y2="15" /></svg>')
                ->tooltip('delete')
                ->class('bg-red-500 text-white px-3 py-2 m-1 rounded text-sm')
                ->openModal('delete-modal', [
                    'data_id'                 => 'id',
                    'TableName'               => 'm_penjualans',
                    'confirmationTitle'       => 'Delete Penjualan Barang',
                    'confirmationDescription' => 'apakah yakin ingin hapus Penjualan Barang?',
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
     * PowerGrid MPenjualan Action Rules.
     *
     * @return array<int, \PowerComponents\LivewirePowerGrid\Rules\RuleActions>
     */

    /*
    public function actionRules(): array
    {
       return [
           
           //Hide button edit for ID 1
            Rule::button('edit')
                ->when(fn($m-penjualan) => $m-penjualan->id === 1)
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
     * PowerGrid MPenjualan Update.
     *
     * @param array<string,string> $data
     */

    /*
    public function update(array $data ): bool
    {
       try {
           $updated = MPenjualan::query()->findOrFail($data['id'])
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
