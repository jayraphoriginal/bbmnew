<?php

namespace App\Http\Livewire\Inventaris;

use Livewire\Component;
use LivewireUI\Modal\ModalComponent;

class InventarisModal extends ModalComponent
{
    public function render()
    {
        return view('livewire.inventaris.inventaris-modal');
    }
}
