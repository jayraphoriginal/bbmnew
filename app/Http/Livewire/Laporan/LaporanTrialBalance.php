<?php

namespace App\Http\Livewire\Laporan;

use Livewire\Component;
use LivewireUI\Modal\ModalComponent;

class LaporanTrialBalance extends ModalComponent
{
    public $bulan, $tahun;

    public function render()
    {
        return view('livewire.laporan.laporan-trial-balance');
    }
}
