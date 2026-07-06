<?php

namespace App\Http\Livewire\Penerimaan;

use App\Models\Invoice;
use App\Models\VInvoiceHeader;
use Livewire\Component;

class InvoiceSelect extends Component
{

    public $search;
    public $invoices;
    public $noinvoice;
    public $customer_id;

    protected $listeners = ['selectdata' => 'selectNoinvoice'];

    public function mount($noinvoice, $customer_id )
    {
        $this->noinvoice=$noinvoice;
        $this->customer_id=$customer_id;
    }

    public function updatedCustomerId()
    {
        $this->reset(['search', 'invoices', 'noinvoice']);
    }

    public function resetdata()
    {
        $this->search = '';
        $this->invoices = [];
    }

    public function selectdata($id)
    {
        $this->noinvoice = VInvoiceHeader::find($id)->noinvoice;
        $this->emitTo('penerimaan.penerimaan-pph23-modal','selectinvoice', $id);
    }

    public function selectNoinvoice($id){
        $this->noinvoice = VInvoiceHeader::find($id)->noinvoice;
    }

    public function updatedSearch()
    {

        if (!$this->customer_id || !$this->search) {
            $this->invoices = [];
            return;
        }

        $this->invoices = VInvoiceHeader::where('customer_id', $this->customer_id)
                        ->where(function($q) {
                            $q->where('noinvoice', 'like', '%' . $this->search . '%');
                        })
                        ->get();
    }

    public function render()
    {
        return view('livewire.penerimaan.invoice-select');
    }
}
