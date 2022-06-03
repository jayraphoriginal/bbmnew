<?php

namespace App\Http\Livewire\Invoice;

use LivewireUI\Modal\ModalComponent;

class SoModal extends ModalComponent
{
    public $tipe;

    public function render()
    {
        return view('livewire.invoice.so-modal');
    }

    public static function modalMaxWidth(): string
    {
        return '7xl';
    }
}
