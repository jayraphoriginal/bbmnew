<?php

namespace App\Http\Livewire\Batal;

use App\Models\VInvoiceHeader;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use LivewireUI\Modal\ModalComponent;
use Throwable;

class BatalInvoiceModal extends ModalComponent
{

    public $invoice_id, $total, $detailinvoice;
    use LivewireAlert;

    protected $listeners = [
        'selectinvoice' => 'selectinvoice',
    ];

    public function mount(){
        $user = Auth::user();
        if (!$user->hasPermissionTo('Pembatalan Invoice')){
            return abort(401);
        }
    }

    public function selectinvoice($id){
        $this->invoice_id=$id;
        $invoice = VInvoiceHeader::find($id);
        $this->total = $invoice->total;
        $this->detailinvoice = $invoice->noinvoice.' - '.$invoice->nama_customer;
    }

    public function save(){

        $this->validate([
            'invoice_id' => 'required'
        ]);

        DB::beginTransaction();

        try{

            DB::update('Exec SP_BatalInvoice '.$this->invoice_id);

            DB::commit();
            $this->closeModal();

            $this->alert('success', 'Save Success', [
                'position' => 'center'
            ]);

            $this->emitTo('invoice.invoice-table', 'pg:eventRefresh-default');
        }catch(Throwable $e){
            DB::rollback();
            $this->alert('error', $e->getMessage(), [
                'position' => 'center'
            ]);
        }

    }

    public function render()
    {
        return view('livewire.batal.batal-invoice-modal');
    }
}
