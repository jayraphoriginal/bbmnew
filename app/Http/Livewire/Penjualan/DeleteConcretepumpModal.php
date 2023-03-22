<?php

namespace App\Http\Livewire\Penjualan;

use App\Models\Concretepump;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use LivewireUI\Modal\ModalComponent;

class DeleteConcretepumpModal extends ModalComponent
{
    use LivewireAlert;
    public $concretepump_id;
   
    public function delete(){
        $concretepump = Concretepump::find($this->concretepump_id);
        $concretepump->delete();

        $this->alert('success', 'Delete Success', [
            'position' => 'center'
        ]);

        $this->emitTo('penjualan.rekap-concretepump-table', 'pg:eventRefresh-default');
    }

    public function cancel(){

        $this->closeModal();

    }

    public function render()
    {
        return view('livewire.penjualan.delete-concretepump-modal');
    }
}
