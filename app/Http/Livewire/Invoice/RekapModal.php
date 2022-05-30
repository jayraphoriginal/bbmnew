<?php

namespace App\Http\Livewire\Invoice;

use Livewire\Component;
use LivewireUI\Modal\ModalComponent;

class RekapModal extends ModalComponent
{
    public $tipe;

    public function render()
    {
        return view('livewire.invoice.rekap-modal');
    }

    public static function modalMaxWidth(): string
    {
        return '7xl';
    }
}
