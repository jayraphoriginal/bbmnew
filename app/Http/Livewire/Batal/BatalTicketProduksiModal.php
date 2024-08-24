<?php

namespace App\Http\Livewire\Batal;

use App\Models\VTicketProduksi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use LivewireUI\Modal\ModalComponent;
use Throwable;

class BatalTicketProduksiModal extends ModalComponent
{
    public $ticket_id, $kode_mutu, $nopol, $jumlah, $detailticket;
    use LivewireAlert;

    protected $listeners = [
        'selectticketprod' => 'selectticketprod',
    ];

    public function mount(){
        $user = Auth::user();
        if (!$user->hasPermissionTo('Pembatalan Ticket')){
            return abort(401);
        }
    }

    public function selectticketprod($id){
        $this->ticket_id=$id;
        $ticket = VTicketProduksi::find($id);
        $this->kode_mutu = $ticket->kode_mutu;
        $this->nopol = $ticket->nopol;
        $this->jumlah = $ticket->jumlah;
        $this->detailticket = $ticket->noticket.' - '.$ticket->deskripsi;
    }

    public function save(){

        $this->validate([
            'ticket_id' => 'required'
        ]);

        DB::beginTransaction();

        try{

            DB::statement('SET NOCOUNT ON; Exec SP_BatalTicketProduksi '.$this->ticket_id);

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
        return view('livewire.batal.batal-ticket-produksi-modal');
    }
}
