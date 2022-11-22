<?php

namespace App\Http\Livewire\Produksi;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ProduksiComponent extends Component
{
    public function render()
    {
        $user = Auth::user();
        if (!$user->hasPermissionTo('Produksi')){
            return abort(401);
        }
        return view('livewire.produksi.produksi-component');
    }
}
