<?php

namespace App\Http\Livewire\Penjualan;

use App\Models\MSalesorder;
use LivewireUI\Modal\ModalComponent;

class RekapPenjualanModal extends ModalComponent
{
    public $m_salesorder_id, $noso;

    public function mount(){
        $this->noso = MSalesorder::find($this->m_salesorder_id)->noso;
    }

    public function render()
    {
        return view('livewire.penjualan.rekap-penjualan-modal');
    }

    public static function modalMaxWidth(): string
    {
        return '7xl';
    }
}
