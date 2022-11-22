<?php

namespace App\Http\Livewire\Inventaris;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class InventarisComponent extends Component
{
    public function render()
    {
        $user = Auth::user();
        if (!$user->hasPermissionTo('Inventaris')){
            return abort(401);
        }
        return view('livewire.inventaris.inventaris-component');
    }
}
