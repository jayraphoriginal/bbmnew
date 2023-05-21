<?php

namespace App\Http\Livewire\Laporan;

use Livewire\Component;
use LivewireUI\Modal\ModalComponent;

class LaporanNeraca extends ModalComponent
{
    public $tanggal;
    public function render()
    {
        return view('livewire.laporan.laporan-neraca');
    }
}
