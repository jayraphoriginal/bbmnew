<?php

namespace App\Http\Livewire\Penjualan;

use App\Models\MSalesorder;
use Livewire\Component;
use LivewireUI\Modal\ModalComponent;

class RekapConcretepumpModal extends ModalComponent
{
    public $m_salesorder_id, $noso;

    public function mount($m_salesorder_id)
    {
        $this->m_salesorder_id = $m_salesorder_id;
        $this->noso = MSalesorder::find($m_salesorder_id)->noso;
    }

    public function render()
    {
        return view('livewire.penjualan.rekap-concretepump-modal');
    }

    public static function modalMaxWidth(): string
    {
        return '7xl';
    }
}
