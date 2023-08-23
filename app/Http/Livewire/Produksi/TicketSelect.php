<?php

namespace App\Http\Livewire\Produksi;

use App\Models\VTicketProduksi;
use Livewire\Component;

class TicketSelect extends Component
{

    public $search;
    public $ticket;
    public $deskripsi;

    protected $listeners = ['selectdata' => 'selectDeskripsi'];

    public function mount($deskripsi)
    {
        $this->deskripsi=$deskripsi;
    }

    public function resetdata()
    {
        $this->search = '';
        $this->ticket = [];
    }

    public function selectdata($id)
    {
        $ticket = VTicketProduksi::find($id);
        $this->deskripsi = $ticket->noticket.' - '.$ticket->sisa.' '.$ticket->satuan;
        $this->emitTo('produksi.produksi-new-modal','selectticket', $id);
    }

    public function selectDeskripsi($id){
        $ticket = VTicketProduksi::find($id);
        $this->deskripsi = $ticket->noticket.' - '.$ticket->sisa.' '.$ticket->satuan;
    }

    public function updatedSearch()
    {
        $this->ticket = VTicketProduksi::where('noticket', 'like', '%' . $this->search . '%')
            ->where('status','Open')
            ->get();
    }
    public function render()
    {
        return view('livewire.produksi.ticket-select');
    }
}
