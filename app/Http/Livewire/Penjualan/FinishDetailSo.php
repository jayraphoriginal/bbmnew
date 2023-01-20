<?php

namespace App\Http\Livewire\Penjualan;

use App\Models\DSalesorder;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use LivewireUI\Modal\ModalComponent;

class FinishDetailSo extends ModalComponent
{
    use LivewireAlert;
    public $m_salesorder_id;

    public function confirm(){

        DSalesorder::where('m_salesorder_id', $this->m_salesorder_id)
        ->update(['status_detail' => 'finish']);

        $this->alert('success', 'Finish Success', [
            'position' => 'center'
        ]);

        $this->emitTo('penjualan.salesorder-full-table', 'pg:eventRefresh-default');
    }

    public function cancel(){

        $this->closeModal();

    }

    public function render()
    {
        return view('livewire.penjualan.finish-detail-so');
    }
}
