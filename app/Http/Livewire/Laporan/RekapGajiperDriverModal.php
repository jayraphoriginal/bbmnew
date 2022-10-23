<?php

namespace App\Http\Livewire\Laporan;

use Livewire\Component;
use LivewireUI\Modal\ModalComponent;

class RekapGajiperDriverModal extends ModalComponent
{
    public $tgl_awal, $tgl_akhir, $driver_id, $driver;

    protected $listeners = [
        'selectdriver' => 'selectdriver',
    ];

    public function selectdriver($id){
        $this->driver_id=$id;
    }

    public function render()
    {
        return view('livewire.laporan.rekap-gajiper-driver-modal');
    }
}
