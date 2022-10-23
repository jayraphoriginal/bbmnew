<?php

namespace App\Http\Livewire\Batal;

use App\Models\Ticket;
use App\Models\VTicket;
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
        $ticket = VTicket::find($id);
        $this->deskripsi = $ticket->noticket.' - '.$ticket->nama_customer;
        $this->emitTo('batal.batal-ticket-modal','selectticket', $id);
    }

    public function selectDeskripsi($id){
        $ticket = VTicket::find($id);
        $this->deskripsi = $ticket->noticket.' - '.$ticket->nama_customer;
    }

    public function updatedSearch()
    {
        $this->ticket = VTicket::where('nama_customer', 'like', '%' . $this->search . '%')
            ->orwhere('noticket','like', '%' . $this->search . '%')
            ->get();
    }

    public function render()
    {
        return view('livewire.batal.ticket-select');
    }
}
