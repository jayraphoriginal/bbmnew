<?php

namespace App\Http\Livewire\Invoice;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class InvoiceComponent extends Component
{
    public function render()
    {
        $user = Auth::user();
        if (!$user->hasPermissionTo('Invoice')){
            return abort(401);
        }
        return view('livewire.invoice.invoice-component');
    }
}
