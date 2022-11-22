<?php

namespace App\Http\Livewire\Penjualan;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class PenjualanRetailComponent extends Component
{
    public function render()
    {
        $user = Auth::user();
        if (!$user->hasPermissionTo('Penjualan Retail')){
            return abort(401);
        }
        return view('livewire.penjualan.penjualan-retail-component');
    }
}
