<?php

namespace App\Http\Livewire\Batal;

use App\Models\VTicketProduksi;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class TicketProduksiSelect extends Component
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
        $this->deskripsi = $ticket->noticket.' - '.$ticket->deskripsi;
        $this->emitTo('batal.batal-ticket-produksi-modal','selectticketprod', $id);
    }

    public function selectDeskripsi($id){
        $ticket = VTicketProduksi::find($id);
        $this->deskripsi = $ticket->noticket.' - '.$ticket->deskripsi;
    }

    public function updatedSearch()
    {
        $this->ticket = VTicketProduksi::where(
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
        return view('livewire.batal.ticket-produksi-select');
    }
}
