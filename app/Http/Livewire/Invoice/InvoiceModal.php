<?php

namespace App\Http\Livewire\Invoice;

use Livewire\Component;
use LivewireUI\Modal\ModalComponent;

class InvoiceModal extends ModalComponent
{
    public function render()
    {
        return view('livewire.invoice.invoice-modal');
    }
}
