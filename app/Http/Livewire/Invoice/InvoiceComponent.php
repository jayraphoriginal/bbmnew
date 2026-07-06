<?php

namespace App\Http\Livewire\Invoice;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class InvoiceComponent extends Component
{
    public $tahun;

    public function mount()
    {
        $this->tahun = (int) date('Y');
    }

    public function updateTable()
    {
        $this->emitTo('invoice.invoice-table', 'pg:eventRefresh-default');
    }

    public function render()
    {
        $user = Auth::user();
        if (!$user->hasPermissionTo('Invoice')){
            return abort(401);
        }
        return view('livewire.invoice.invoice-component');
    }
}
