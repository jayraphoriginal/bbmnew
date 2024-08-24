<?php

namespace App\Http\Livewire\Penjualan;

use LivewireUI\Modal\ModalComponent;

class TanggalWoModal extends ModalComponent
{

    public $so_id, $tgl;

    public function mount(){
        $this->tgl = Date('Y-m-d');
    }

    public function render()
    {
        return view('livewire.penjualan.tanggal-wo-modal');
    }
}
