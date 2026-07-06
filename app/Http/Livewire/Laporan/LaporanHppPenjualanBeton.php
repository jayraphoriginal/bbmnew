<?php

namespace App\Http\Livewire\Laporan;

use LivewireUI\Modal\ModalComponent;

class LaporanHppPenjualanBeton extends ModalComponent
{
    public $tgl_berlaku;
    public function render()
    {
        return view('livewire.laporan.laporan-hpp-penjualan-beton');
    }
}
