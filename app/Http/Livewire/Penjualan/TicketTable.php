<?php

namespace App\Http\Livewire\Penjualan;

use App\Models\Ticket;
use App\Models\VTicket;
use App\Models\VTicketHeader;
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

final class TicketTable extends PowerGridComponent
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
    * @return  \Illuminate\Database\Eloquent\Builder<\App\Models\Ticket>|null
    */
    public function datasource(): ?Builder
    {
        return VTicketHeader::
        where('V_TicketHeader.so_id', $this->m_salesorder_id)
        ->select('V_TicketHeader.*');
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
            ->addColumn('no')
            ->addColumn('noticket')
            ->addColumn('nourut')
            ->addColumn('customer_id')
            ->addColumn('nama_customer')
            ->addColumn('d_purchaseorder_id')
            ->addColumn('mutubeton_id')
            ->addColumn('kode_mutu')
            ->addColumn('deskripsi')
            ->addColumn('noticket')
            ->addColumn('kendaraan_id')
            ->addColumn('nopol')
            ->addColumn('driver_id')
            ->addColumn('nama_driver')
            ->addColumn('jam_ticket', function(VTicketHeader $model) { 
                return Carbon::parse($model->jam_ticket)->format('d/m/Y H:i:s');
            })
            ->addColumn('jumlah')
            ->addColumn('satuan_id')
            ->addColumn('satuan')
            ->addColumn('loading')
            ->addColumn('tambahan_biaya')
            ->addColumn('created_at_formatted', function(VTicketHeader $model) { 
                return Carbon::parse($model->created_at)->format('d/m/Y H:i:s');
            })
            ->addColumn('updated_at_formatted', function(VTicketHeader $model) { 
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
            ->title('NO')
            ->field('nourut')
            ->sortable(),

            Column::add()
            ->title('NO TICKET')
            ->field('noticket')
            ->sortable()
            ->searchable()
            ->makeInputText(),

            Column::add()
                ->title('CUSTOMER')
                ->field('nama_customer')
                ->sortable()
                ->searchable()
                ->makeInputText(),

            Column::add()
                ->title('MUTU BETON')
                ->field('deskripsi')
                ->sortable()
                ->searchable()
                ->makeInputText(),

            Column::add()
                ->title('KENDARAAN')
                ->field('nopol')
                ->sortable()
                ->searchable()
                ->makeInputText(),

            Column::add()
                ->title('DRIVER')
                ->field('nama_driver')
                ->sortable()
                ->searchable()
                ->makeInputText(),
           
            Column::add()
                ->title('JUMLAH')
                ->field('jumlah'),

            Column::add()
                ->title('SATUAN')
                ->field('satuan')
                ->sortable()
                ->searchable()
                ->makeInputText(),

            Column::add()
                ->title('LOADING')
                ->field('loading'),

            Column::add()
                ->title('TAMBAHAN BIAYA')
                ->field('tambahan_biaya'),

            Column::add()
                ->title('JAM TICKET')
                ->field('jam_ticket')
                ->sortable()
                ->searchable()
                ->makeInputDatePicker(),
            
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
     * PowerGrid Ticket Action Buttons.
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
            ->route("printticket",[
                'id' => 'id'
            ]),

            Button::add('edit')
            ->caption('<svg class="h-5 w-5 text-white" <svg  width="24"  height="24"  viewBox="0 0 24 24"  xmlns="http://www.w3.org/2000/svg"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round">  <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />  <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z" /></svg>')
            ->class('bg-yellow-500 cursor-pointer text-white px-3 py-2 m-1 rounded text-sm')
            ->tooltip('update')
            ->class('bg-indigo-500 cursor-pointer text-white px-3 py-2 m-1 rounded text-sm')
            ->openModal('penjualan.ticket-edit-modal',[
                'ticket_id' => 'id'
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
     * PowerGrid Ticket Action Rules.
     *
     * @return array<int, \PowerComponents\LivewirePowerGrid\Rules\RuleActions>
     */

    /*
    public function actionRules(): array
    {
       return [
           
           //Hide button edit for ID 1
            Rule::button('edit')
                ->when(fn($ticket) => $ticket->id === 1)
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
     * PowerGrid Ticket Update.
     *
     * @param array<string,string> $data
     */

    /*
    public function update(array $data ): bool
    {
       try {
           $updated = Ticket::query()->findOrFail($data['id'])
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
