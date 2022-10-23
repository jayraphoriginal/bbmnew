<?php

namespace App\Http\Livewire\Batal;

use App\Models\VTicket;
use Throwable;
use DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use LivewireUI\Modal\ModalComponent;

class BatalTicketModal extends ModalComponent
{
    public $ticket_id, $kode_mutu, $nopol, $jumlah, $detailticket;
    use LivewireAlert;

    protected $listeners = [
        'selectticket' => 'selectticket',
    ];

    public function selectticket($id){
        $this->ticket_id=$id;
        $ticket = VTicket::find($id);
        $this->kode_mutu = $ticket->kode_mutu;
        $this->nopol = $ticket->nopol;
        $this->jumlah = $ticket->jumlah;
        $this->detailticket = $ticket->noticket.' - '.$ticket->nama_customer;
    }

    public function save(){

        $this->validate([
            'ticket_id' => 'required'
        ]);

        DB::beginTransaction();

        try{

            DB::update('Exec SP_BatalTicket '.$this->ticket_id);

            DB::commit();
            $this->closeModal();

            $this->alert('success', 'Save Success', [
                'position' => 'center'
            ]);
        }catch(Throwable $e){
            DB::rollback();
            $this->alert('error', $e->getMessage(), [
                'position' => 'center'
            ]);
        }

    }

    public function render()
    {
        return view('livewire.batal.batal-ticket-modal');
    }
}
