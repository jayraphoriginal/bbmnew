<?php

namespace App\Http\Livewire\Penjualan;

use App\Models\DSalesorder;
use App\Models\MSalesorder;
use Livewire\Component;
use LivewireUI\Modal\ModalComponent;

class RekapTicketModal extends ModalComponent
{
    public $m_salesorder_id, $mutubeton_id;
    public $noso;

    public function mount($m_salesorder_id, $mutubeton_id){
        $this->m_salesorder_id = $m_salesorder_id;
        $this->mutubeton_id=$mutubeton_id;
        $msalesorder = MSalesorder::find($m_salesorder_id);
        $this->noso = $msalesorder->noso;
    }

    public function render()
    {
        return view('livewire.penjualan.rekap-ticket-modal');
    }

    public static function modalMaxWidth(): string
    {
        return '7xl';
    }
}
