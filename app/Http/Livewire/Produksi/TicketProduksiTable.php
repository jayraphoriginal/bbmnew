<?php

namespace App\Http\Livewire\Produksi;

use App\Models\VTicketProduksi;
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

final class TicketProduksiTable extends PowerGridComponent
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
    * @return  \Illuminate\Database\Eloquent\Builder<\App\Models\VTicketProduksi>|null
    */
    public function datasource(): ?Builder
    {
        return VTicketProduksi::where(
            'status','<>','cancel'
        );
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
            ->addColumn('ticket_id')
            ->addColumn('noticket')
            ->addColumn('deskripsi')
            ->addColumn('nopol')
            ->addColumn('nama_driver')
            ->addColumn('tujuan')
            ->addColumn('estimasi_jarak')
            
            ->addColumn('jam_ticket')
            ->addColumn('jam_ticket_formatted', function(VTicketProduksi $model) {
                return Carbon::parse($model->jam_ticket)->format('d/m/Y H:i:s');
            })
            ->addColumn('jumlah')
            ->addColumn('jumlah_formatted', function(VTicketProduksi $model) {
                return number_format($model->jumlah,2,',','.');
            })
            ->addColumn('satuan')
            ->addColumn('loading')
            ->addColumn('loading_formatted', function(VTicketProduksi $model) {
                return number_format($model->loading,2,',','.');
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
                ->title('NO TICKET')
                ->field('noticket')
                ->searchable()
                ->makeInputText('noticket')
                ->sortable(),

            Column::add()
                ->title('KODE MUTU')
                ->field('deskripsi')
                ->searchable()
                ->makeInputText('deskripsi')
                ->sortable(),

            Column::add()
                ->title('JUMLAH')
                ->field('jumlah_formatted','jumlah')
                ->searchable()
                ->makeInputRange()
                ->sortable(),

            Column::add()
                ->title('SATUAN')
                ->field('satuan')
                ->searchable()
                ->makeInputText('satuan')
                ->sortable(),

            Column::add()
                ->title('NO POLISI')
                ->field('nopol')
                ->searchable()
                ->makeInputText('nopol')
                ->sortable(),

            Column::add()
                ->title('NAMA DRIVER')
                ->field('nama_driver')
                ->searchable()
                ->makeInputText('nama_driver')
                ->sortable(),

            Column::add()
                ->title('TUJUAN')
                ->field('tujuan')
                ->searchable()
                ->makeInputText('tujuan')
                ->sortable(),

            Column::add()
                ->title('JARAK')
                ->field('estimasi_jarak')
                ->searchable()
                ->makeInputText('estimasi_jarak')
                ->sortable(),

            Column::add()
                ->title('JAM TICKET')
                ->field('jam_ticket')
                ->hidden(),

            Column::add()
                ->title('JAM TICKET')
                ->field('jam_ticket_formatted')
                ->makeInputDatePicker('jam_ticket')
                ->searchable(),



            Column::add()
                ->title('LOADING')
                ->field('loading_formatted','loading')
                ->searchable()
                ->makeInputText('loading')
                ->sortable(),

           
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
     * PowerGrid VTicketProduksi Action Buttons.
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
            ->route("printticketproduksi",[
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
     * PowerGrid VTicketProduksi Action Rules.
     *
     * @return array<int, \PowerComponents\LivewirePowerGrid\Rules\RuleActions>
     */

    /*
    public function actionRules(): array
    {
       return [
           
           //Hide button edit for ID 1
            Rule::button('edit')
                ->when(fn($v-ticket-produksi) => $v-ticket-produksi->id === 1)
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
     * PowerGrid VTicketProduksi Update.
     *
     * @param array<string,string> $data
     */

    /*
    public function update(array $data ): bool
    {
       try {
           $updated = VTicketProduksi::query()
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
