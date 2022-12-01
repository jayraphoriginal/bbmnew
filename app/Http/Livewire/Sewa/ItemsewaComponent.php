<?php

namespace App\Http\Livewire\Sewa;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ItemsewaComponent extends Component
{
    public function render()
    {
        $user = Auth::user();
        if (!$user->hasPermissionTo('Item Sewa')){
            return abort(401);
        }
        return view('livewire.sewa.itemsewa-component');
    }
}
