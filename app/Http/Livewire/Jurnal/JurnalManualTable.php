<?php

namespace App\Http\Livewire\Jurnal;

use App\Models\ManualJournal;
use App\Models\VJurnal;
use App\Models\VJurnalManual;
use App\Models\VTmpJurnalManual;
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

final class JurnalManualTable extends PowerGridComponent
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
    * @return  \Illuminate\Database\Eloquent\Builder<\App\Models\ManualJournal>|null
    */
    public function datasource(): ?Builder
    {
        return VJurnalManual::query();
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
            ->addColumn('tanggal')
            ->addColumn('nobuktikas')
            ->addColumn('tanggal_formatted', function(VJurnalManual $model) {
                return Carbon::parse($model->tanggal)->format('d/m/Y');
            })
            ->addColumn('kode_akun')
            ->addColumn('bukti_kas')
            ->addColumn('nama_akun')
            ->addColumn('debet', function(VJurnalManual $model) {
                return number_format($model->debet,2,'.',',');
            })
            ->addColumn('kredit', function(VJurnalManual $model) {
                return number_format($model->kredit,2,'.',',');
            })
            ->addColumn('keterangan')
            ->addColumn('created_at')
            ->addColumn('created_at_formatted', function(VJurnalManual $model) {
                return Carbon::parse($model->created_at)->format('d/m/Y H:i:s');
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
                ->title('TANGGAL')
                ->field('tanggal_formatted','tanggal')
                ->makeInputDatePicker()
                ->searchable()
                ->sortable(),

            Column::add()
                ->title('NO BUKTI KAS')
                ->field('nobuktikas')
                ->searchable()
                ->makeInputText()
                ->sortable(),

            Column::add()
                ->title('KODE AKUN')
                ->field('kode_akun')
                ->searchable()
                ->makeInputText()
                ->sortable(),
            
            Column::add()
                ->title('NAMA AKUN')
                ->field('nama_akun')
                ->searchable()
                ->makeInputText()
                ->sortable(),
            
            Column::add()
                ->title('DEBET')
                ->field('debet')
                ->searchable()
                ->makeInputRange()
                ->sortable(),

            Column::add()
                ->title('KREDIT')
                ->field('kredit')
                ->searchable()
                ->makeInputRange()
                ->sortable(),

            Column::add()
                ->title('KETERANGAN')
                ->field('keterangan')
                ->searchable()
                ->makeInputText()
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
     * PowerGrid ManualJournal Action Buttons.
     *
     * @return array<int, \PowerComponents\LivewirePowerGrid\Button>
     */

    
    public function actions(): array
    {
       return [
            Button::add('destroy')
            ->caption('<svg class="h-5 w-5 text-white"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round">  <circle cx="12" cy="12" r="10" />  <line x1="15" y1="9" x2="9" y2="15" />  <line x1="9" y1="9" x2="15" y2="15" /></svg>')
            ->class('bg-red-500 text-white px-3 py-2 m-1 rounded text-sm')
            ->tooltip('delete')
            ->openModal('batal.batal-jurnal-manual', [
                'manual_journal_id' => 'id',
            ]),

            Button::add('buktikas')
            ->caption('<span class="material-icons align-middle text-center">payments</span>')
            ->class('bg-blue-500 cursor-pointer text-white px-3 py-2 m-1 rounded text-sm')
            ->target('_blank')
            ->method('get')
            ->route("printbuktikasmanual",[
                'id' => 'id',
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
     * PowerGrid ManualJournal Action Rules.
     *
     * @return array<int, \PowerComponents\LivewirePowerGrid\Rules\RuleActions>
     */

    
    public function actionRules(): array
    {
       return [
           
           //Hide button edit for ID 1
           Rule::button('buktikas')
           ->when(fn(VJurnalManual $model) => $model->bukti_kas == 'lain-lain' || $model->bukti_kas == '')
           ->hide(),
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
     * PowerGrid ManualJournal Update.
     *
     * @param array<string,string> $data
     */

    /*
    public function update(array $data ): bool
    {
       try {
           $updated = ManualJournal::query()
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
