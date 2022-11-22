<?php

namespace App\Http\Livewire\Penjualan;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class SalesorderComponent extends Component
{
    public function render()
    {
        $user = Auth::user();
        if (!$user->hasPermissionTo('PO Customer')){
            return abort(401);
        }
        return view('livewire.penjualan.salesorder-component');
    }
}
