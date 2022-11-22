<?php

namespace App\Http\Livewire\Penjualan;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class PenjualanComponent extends Component
{
    public function render()
    {
        $user = Auth::user();
        if (!$user->hasPermissionTo('Penjualan Barang')){
            return abort(401);
        }
        return view('livewire.penjualan.penjualan-component');
    }
}
