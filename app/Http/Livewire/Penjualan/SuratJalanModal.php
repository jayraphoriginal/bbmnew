<?php

namespace App\Http\Livewire\Penjualan;

use LivewireUI\Modal\ModalComponent;

class SuratJalanModal extends ModalComponent
{
    public function render()
    {
        return view('livewire.penjualan.surat-jalan-modal');
    }
}