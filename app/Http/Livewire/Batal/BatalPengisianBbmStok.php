<?php

namespace App\Http\Livewire\Batal;

use App\Models\PengisianBbmStok;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use LivewireUI\Modal\ModalComponent;
use Throwable;

class BatalPengisianBbmStok extends ModalComponent
{
    public $pengisian_bbm_stok_id, $tgl_pengisian, $total, $keterangan;
    use LivewireAlert;

    protected $listeners = [
        'selectid' => 'selectid',
    ];

    public function mount(){
        $user = Auth::user();
        if (!$user->hasPermissionTo('Batal Pengisian Bbm Stok')){
            return abort(401);
        }
    }

    public function selectid($id){
        $this->pengisian_bbm_stok_id=$id;
        $pengisianbbmstok = PengisianBbmStok::find($id);
        $this->tgl_pengisian = $pengisianbbmstok->tgl_pengisian;
        $this->total = $pengisianbbmstok->total;
        $this->keterangan = $pengisianbbmstok->ket;
    }

    public function save(){
        $this->validate([
            'pengeluaran_biaya_id' => 'required'
        ]);

        DB::beginTransaction();

        try{

            DB::statement("SET NOCOUNT ON; Exec SP_BatalPengisianBbmStok ".$this->pengisian_bbm_stok_id);
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
        return view('livewire.batal.batal-pengisian-bbm-stok');
    }
}
