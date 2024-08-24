<?php

namespace App\Http\Livewire\Batal;

use App\Models\VPembayaran;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use LivewireUI\Modal\ModalComponent;
use Throwable;

class BatalPembayaran extends ModalComponent
{
    public $pembayaran_id, $total, $detailpembayaran;
    use LivewireAlert;

    protected $listeners = [
        'selectpembayaran' => 'selectpembayaran',
    ];

    public function mount(){
        $user = Auth::user();
        if (!$user->hasPermissionTo('Pembatalan Pembayaran')){
            return abort(401);
        }
    }

    public function selectpembayaran($id){
        $this->pembayaran_id=$id;
        $pembayaran = VPembayaran::find($id);
        $this->total = $pembayaran->jumlah;
        $this->detailpembayaran = $pembayaran->nopembayaran.' - '.$pembayaran->keterangan;
    }

    public function save(){

        $this->validate([
            'pembayaran_id' => 'required'
        ]);

        DB::beginTransaction();

        try{

            DB::update('Exec SP_BatalPembayaran '.$this->pembayaran_id);

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
        return view('livewire.batal.batal-pembayaran');
    }
}
