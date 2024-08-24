<?php

namespace App\Http\Livewire\Batal;

use App\Models\VOpname;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use LivewireUI\Modal\ModalComponent;
use Throwable;

class BatalStokOpname extends ModalComponent
{

    public $stokopname_id, $nama_barang, $jumlah, $detailopname;
    use LivewireAlert;

    protected $listeners = [
        'selectstokopname' => 'selectstokopname',
    ];

    public function mount(){
        $user = Auth::user();
        if (!$user->hasPermissionTo('Batal Stok Opname')){
            return abort(401);
        }
    }

    public function selectstokopname($id){
        $this->stokopname_id=$id;
        $stokopname = VOpname::find($id);
        $this->nama_barang = $stokopname->nama_barang;
        $this->jumlah = $stokopname->jumlah;
        $this->detailopname = $stokopname->noopname.' - '.$stokopname->keterangan;
    }

    public function save(){

        $this->validate([
            'stokopname_id' => 'required'
        ]);

        DB::beginTransaction();

        try{

            DB::statement('SET NOCOUNT ON; Exec SP_BatalStokOpname '.$this->stokopname_id);

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
        return view('livewire.batal.batal-stok-opname');
    }
}
