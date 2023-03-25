<?php

namespace App\Http\Livewire\Laporan;

use LivewireUI\Modal\ModalComponent;

class LaporanKartustok extends ModalComponent
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
        return view('livewire.laporan.laporan-kartustok');
    }
}
