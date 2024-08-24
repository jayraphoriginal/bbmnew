<?php

namespace App\Http\Livewire\Batal;

use App\Models\Ticket;
use App\Models\VTicket;
use App\Models\VTicketHeaderAll;
use Illuminate\Support\Facades\DB;
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
        $ticket = VTicketHeaderAll::find($id);
        $this->deskripsi = $ticket->noticket.' - '.$ticket->nama_customer;
        $this->emitTo('batal.batal-ticket-modal','selectticket', $id);
    }

    public function selectDeskripsi($id){
        $ticket = VTicketHeaderAll::find($id);
        $this->deskripsi = $ticket->noticket.' - '.$ticket->nama_customer;
    }

    public function updatedSearch()
    {
        $this->ticket = VTicketHeaderAll::where(
                function($query) {
                    return $query
                           ->where( 'deskripsi', 'LIKE', '%'.$this->search.'%')
                           ->Where('jam_ticket','>=',DB::raw("DATEADD(month, -2, GETDATE())"));
                   })
                ->orwhere(function($query) {
                    return $query
                           ->where( 'noticket', 'LIKE', '%'.$this->search.'%')
                           ->Where('jam_ticket','>=',DB::raw("DATEADD(month, -2, GETDATE())"));
                   })
                ->get();
    }

    public function render()
    {
        return view('livewire.batal.ticket-select');
    }
}
