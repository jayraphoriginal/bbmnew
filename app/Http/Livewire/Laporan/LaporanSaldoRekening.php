<?php

namespace App\Http\Livewire\Laporan;

use Livewire\Component;
use LivewireUI\Modal\ModalComponent;

class LaporanSaldoRekening extends ModalComponent
{

    public $tgl_awal, $tgl_akhir, $rekening_id, $rekening;

    protected $listeners = [
        'selectrekening' => 'selectrekening',
    ];

    public function selectrekening($id){
        $this->rekening_id=$id;
    }

    public function render()
    {
        return view('livewire.laporan.laporan-saldo-rekening');
    }
}
