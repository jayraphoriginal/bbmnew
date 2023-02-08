<?php

namespace App\Http\Livewire\Laporan;

use Livewire\Component;
use LivewireUI\Modal\ModalComponent;

class RekapInvoice extends ModalComponent
{
    public $tgl_awal, $tgl_akhir, $tipe;
    public function render()
    {
        return view('livewire.laporan.rekap-invoice');
    }
}
