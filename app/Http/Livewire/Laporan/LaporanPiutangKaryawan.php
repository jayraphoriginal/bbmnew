<?php

namespace App\Http\Livewire\Laporan;

use LivewireUI\Modal\ModalComponent;

class LaporanPiutangKaryawan extends ModalComponent
{
    public $tanggal;
    public function render()
    {
        return view('livewire.laporan.laporan-piutang-karyawan');
    }
}
