<?php

namespace App\Http\Livewire\Batal;

use App\Models\PengeluaranBiaya;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use LivewireUI\Modal\ModalComponent;
use Throwable;

class BatalPengeluaranBiaya extends ModalComponent
{

    public $pengeluaran_biaya_id, $total, $keterangan;
    use LivewireAlert;

    protected $listeners = [
        'selectid' => 'selectid',
    ];

    public function mount(){
        $user = Auth::user();
        if (!$user->hasPermissionTo('Batal Pengeluaran Biaya')){
            return abort(401);
        }
    }

    public function selectid($id){
        $this->pengeluaran_biaya_id=$id;
        $pengeluaran_biaya = PengeluaranBiaya::find($id);
        $this->total = $pengeluaran_biaya->total;
        $this->keterangan = $pengeluaran_biaya->ket;
    }

    public function save(){

        $this->validate([
            'pengeluaran_biaya_id' => 'required'
        ]);

        DB::beginTransaction();

        try{

            DB::update('Exec SP_HapusPengeluaranBiaya '.$this->pengeluaran_biaya_id);

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
        return view('livewire.batal.batal-pengeluaran-biaya');
    }
}
