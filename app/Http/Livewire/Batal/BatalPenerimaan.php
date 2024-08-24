<?php

namespace App\Http\Livewire\Batal;

use App\Models\VPembelian;
use App\Models\VPenerimaan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use LivewireUI\Modal\ModalComponent;
use Throwable;

class BatalPenerimaan extends ModalComponent
{
    public $penerimaan_id, $total, $detailpenerimaan;
    use LivewireAlert;

    protected $listeners = [
        'selectpenerimaan' => 'selectpenerimaan',
    ];

    public function mount(){
        $user = Auth::user();
        if (!$user->hasPermissionTo('Pembatalan Penerimaan')){
            return abort(401);
        }
    }

    public function selectpenerimaan($id){
        $this->penerimaan_id=$id;
        $penerimaan = VPenerimaan::find($id);
        $this->total = $penerimaan->jumlah;
        $this->detailpenerimaan = $penerimaan->nopenerimaan.' - '.$penerimaan->keterangan;
    }

    public function save(){

        $this->validate([
            'penerimaan_id' => 'required'
        ]);

        DB::beginTransaction();

        try{

            DB::update('Exec SP_BatalPenerimaan '.$this->penerimaan_id);

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
        return view('livewire.batal.batal-penerimaan');
    }
}
