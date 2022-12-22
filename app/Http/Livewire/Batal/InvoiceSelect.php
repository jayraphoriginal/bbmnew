<?php

namespace App\Http\Livewire\Batal;

use App\Models\VInvoiceHeader;
use Livewire\Component;

class InvoiceSelect extends Component
{
    public $search;
    public $invoice;
    public $deskripsi;

    protected $listeners = ['selectdata' => 'selectDeskripsi'];

    public function mount($deskripsi)
    {
        $this->deskripsi=$deskripsi;
    }

    public function resetdata()
    {
        $this->search = '';
        $this->invoice = [];
    }

    public function selectdata($id)
    {
        $invoice = VInvoiceHeader::find($id);
        $this->deskripsi = $invoice->noinvoice.' - '.$invoice->nama_customer;
        $this->emitTo('batal.batal-invoice-modal','selectinvoice', $id);
    }

    public function selectDeskripsi($id){
        $invoice = VInvoiceHeader::find($id);
        $this->deskripsi = $invoice->noinvoice.' - '.$invoice->nama_customer;
    }

    public function updatedSearch()
    {
        $this->invoice = VInvoiceHeader::where('nama_customer', 'like', '%' . $this->search . '%')
            ->orwhere('noinvoice','like', '%' . $this->search . '%')
            ->get();
    }

    public function render()
    {
        return view('livewire.batal.invoice-select');
    }
}
