<?php

namespace App\Http\Livewire\Sewa;

use App\Models\DSalesorderSewa;
use App\Models\Itemsewa;
use App\Models\MSalesorderSewa;
use Livewire\Component;
use LivewireUI\Modal\ModalComponent;

class RekapTimesheetModal extends ModalComponent
{

    public $d_salesorder_sewa_id, $tipe;
    public $noso;

    public function mount($d_salesorder_sewa_id){
        $this->d_salesorder_sewa_id = $d_salesorder_sewa_id;
        $dsalesordersewa = DSalesorderSewa::find($this->d_salesorder_sewa_id);
        $msalesordersewa = MSalesorderSewa::find($dsalesordersewa->m_salesorder_sewa_id);
        $itemsewa = Itemsewa::find($dsalesordersewa->itemsewa_id);
        $this->tipe = $itemsewa->tipe;
        $this->noso = $msalesordersewa->noso;
    }

    public function render()
    {
        return view('livewire.sewa.rekap-timesheet-modal');
    }

    public static function modalMaxWidth(): string
    {
        return '7xl';
    }
}
