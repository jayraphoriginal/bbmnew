<?php

namespace App\Http\Livewire\Barang;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class BahanbakarComponent extends Component
{
    public function render()
    {
        $user = Auth::user();
        if (!$user->hasPermissionTo('Bahan Bakar')){
            return abort(401);
        }
        return view('livewire.barang.bahanbakar-component');
    }
}
