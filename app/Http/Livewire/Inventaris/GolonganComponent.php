<?php

namespace App\Http\Livewire\Inventaris;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class GolonganComponent extends Component
{
    public function render()
    {
        $user = Auth::user();
        if (!$user->hasPermissionTo('Golongan Inventaris')){
            return abort(401);
        }
        return view('livewire.inventaris.golongan-component');
    }
}
