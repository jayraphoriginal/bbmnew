<?php

namespace App\Http\Livewire\Laporan;

use App\Models\Supplier;
use Livewire\Component;
use LivewireUI\Modal\ModalComponent;

class BukuBesarHutang extends ModalComponent
{
    public $tgl_awal, $tgl_akhir;
    public $id_supplier, $supplier;

    protected $listeners = [
        'selectsupplier' => 'selectsupplier',
    ];

    public function selectsupplier($id){
        $this->id_supplier=$id;
    }

    public function render()
    {
        return view('livewire.laporan.buku-besar-hutang');
    }
}
