<?php

namespace App\Http\Livewire\Penjualan;

use App\Models\DSalesorder;
use App\Models\MSalesorder;
use Livewire\Component;
use LivewireUI\Modal\ModalComponent;

class RekapTicketModal extends ModalComponent
{
    public $d_salesorder_id;
    public $noso;

    public function mount($d_salesorder_id){
        $this->d_salesorder_id = $d_salesorder_id;
        $dsalesorder = DSalesorder::find($d_salesorder_id);
        $msalesorder = MSalesorder::find($dsalesorder->m_salesorder_id);
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
