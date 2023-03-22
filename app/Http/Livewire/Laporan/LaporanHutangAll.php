<?php

namespace App\Http\Livewire\Laporan;

use Livewire\Component;
use LivewireUI\Modal\ModalComponent;

class LaporanHutangAll extends ModalComponent
{
    public $tanggal;
    public function render()
    {
        return view('livewire.laporan.laporan-hutang-all');
    }
}
