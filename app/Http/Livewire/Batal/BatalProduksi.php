<?php

namespace App\Http\Livewire\Batal;

use App\Models\VProduksiProdukturunan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use LivewireUI\Modal\ModalComponent;
use Throwable;

class BatalProduksi extends ModalComponent
{

    public $produksi_id, $nama_barang, $jumlah, $detailproduksi;
    use LivewireAlert;

    protected $listeners = [
        'selectproduksi' => 'selectproduksi',
    ];

    public function mount(){
        $user = Auth::user();
        if (!$user->hasPermissionTo('Batal Produksi')){
            return abort(401);
        }
    }

    public function selectproduksi($id){
        $this->produksi_id=$id;
        $produksi = VProduksiProdukturunan::find($id);
        $this->nama_barang = $produksi->nama_barang;
        $this->jumlah = $produksi->jumlah;
        $this->detailproduksi = date_format(date_create($produksi->tanggal),'d/M/Y').' - '.$produksi->keterangan;
    }

    public function save(){

        $this->validate([
            'produksi_id' => 'required'
        ]);

        DB::beginTransaction();

        try{

            DB::statement('SET NOCOUNT ON; Exec SP_BatalProduksi '.$this->produksi_id);

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
        return view('livewire.batal.batal-produksi');
    }
}
