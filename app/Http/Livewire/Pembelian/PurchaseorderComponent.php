<?php

namespace App\Http\Livewire\Pembelian;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class PurchaseorderComponent extends Component
{
    public function render()
    {
        $user = Auth::user();
        if (!$user->hasPermissionTo('Purchase Order')){
            return abort(401);
        }
        return view('livewire.pembelian.purchaseorder-component');
    }
}
