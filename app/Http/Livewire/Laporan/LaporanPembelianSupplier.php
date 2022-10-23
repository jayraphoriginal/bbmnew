<?php

namespace App\Http\Livewire\Laporan;

use Livewire\Component;
use LivewireUI\Modal\ModalComponent;

class LaporanPembelianSupplier extends ModalComponent
{
    public $tgl_awal, $tgl_akhir;
    public $id_supplier, $supplier;

    protected $listeners = [
        'selectsupplier' => 'selectsupplier',
    ];

    public function selectsupplier($id){
        $this->id_supplier=$id;
    }
    
    public function render()
    {
        return view('livewire.laporan.laporan-pembelian-supplier');
    }
}
