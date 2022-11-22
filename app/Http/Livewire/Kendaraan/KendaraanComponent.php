<?php

namespace App\Http\Livewire\Kendaraan;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class KendaraanComponent extends Component
{
    public function render()
    {
        $user = Auth::user();
        if (!$user->hasPermissionTo('Kendaraan')){
            return abort(401);
        }
        return view('livewire.kendaraan.kendaraan-component');
    }
}
