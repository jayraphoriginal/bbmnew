<?php

namespace App\Http\Livewire\Laporan;

use Livewire\Component;
use LivewireUI\Modal\ModalComponent;

class LaporanKartuStokHarian extends ModalComponent
{

    public $tgl_awal, $tgl_akhir, $barang_id, $barang;

    protected $listeners = [
        'selectbarang' => 'selectbarang',
    ];

    public function selectbarang($id){
        $this->barang_id=$id;
    }

    public function render()
    {
        return view('livewire.laporan.laporan-kartu-stok-harian');
    }
}
