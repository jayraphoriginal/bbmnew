<?php

namespace App\Http\Livewire\Pembayaran;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class PembayaranPembelianComponent extends Component
{
    public function render()
    {
        $user = Auth::user();
        if (!$user->hasPermissionTo('Pembayaran Pembelian')){
            return abort(401);
        }
        return view('livewire.pembayaran.pembayaran-pembelian-component');
    }
}
