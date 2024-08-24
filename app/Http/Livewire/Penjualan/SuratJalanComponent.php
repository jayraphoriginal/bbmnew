<?php

namespace App\Http\Livewire\Penjualan;

use App\Models\MPenjualan;
use Livewire\Component;
use LivewireUI\Modal\ModalComponent;

class SuratJalanComponent extends ModalComponent
{
    public $m_penjualan_id, $mpenjualan;

    public function mount($m_penjualan_id){
        $this->mpenjualan = MPenjualan::find($m_penjualan_id);
        $this->m_penjualan_id = $m_penjualan_id;
    }

    public function render()
    {
        return view('livewire.penjualan.surat-jalan-component');
    }

    public static function modalMaxWidth(): string
    {
        return '7xl';
    }
}
