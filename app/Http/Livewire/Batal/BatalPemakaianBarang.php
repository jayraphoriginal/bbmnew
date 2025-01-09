<?php

namespace App\Http\Livewire\Batal;

use App\Models\PemakaianBarang;
use App\Models\VPemakaianBarang;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use LivewireUI\Modal\ModalComponent;
use Throwable;

class BatalPemakaianBarang extends ModalComponent
{
    public $pemakaian_barang_id, $keterangan, $nama_barang, $alken, $tanggal, $pemakaianbarang;
    use LivewireAlert;

    public function mount(){
        $user = Auth::user();
        if (!$user->hasPermissionTo('Pembatalan Pemakaian Barang')){
            return abort(401);
        }
        $this->pemakaianbarang = PemakaianBarang::select("id")->Where('tgl_pemakaian','>=',DB::raw("DATEADD(month, -2, GETDATE())"))->get();
    }

    public function selectPemakaianBarang(){
        $pemakaianbarang = VPemakaianBarang::find($this->pemakaian_barang_id);
        $this->keterangan = $pemakaianbarang->keterangan;
        $this->nama_barang = $pemakaianbarang->nama_barang;
        $this->alken = $pemakaianbarang->alken;
        $this->tanggal = $pemakaianbarang->tgl_pemakaian;
    }

    public function save(){

        $this->validate([
            'pemakaian_barang_id' => 'required'
        ]);

        DB::beginTransaction();

        try{

            DB::statement("SET NOCOUNT ON; Exec SP_BatalPemakaianBarang ".$this->pemakaian_barang_id);
           
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
        return view('livewire.batal.batal-pemakaian-barang');
    }
}
