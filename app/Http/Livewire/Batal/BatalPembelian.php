<?php

namespace App\Http\Livewire\Batal;

use App\Models\VPembelian;
use App\Models\VPembelianDetail;
use Livewire\Component;
use DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use LivewireUI\Modal\ModalComponent;
use Throwable;

class BatalPembelian extends ModalComponent
{

    public $pembelian_id, $total, $detailpembelian;
    use LivewireAlert;

    protected $listeners = [
        'selectpembelian' => 'selectpembelian',
    ];

    public function selectpembelian($id){
        $this->pembelian_id=$id;
        $pembelian = VPembelian::find($id);
        $this->total = $pembelian->total;
        $this->detailpembelian = $pembelian->nopo.' - '.$pembelian->nama_supplier;
    }

    public function save(){

        $this->validate([
            'pembelian_id' => 'required'
        ]);

        DB::beginTransaction();

        try{

            DB::update('Exec SP_BatalPembelian '.$this->pembelian_id);

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
        return view('livewire.batal.batal-pembelian');
    }
}
