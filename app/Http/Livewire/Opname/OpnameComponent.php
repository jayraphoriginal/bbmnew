<?php

namespace App\Http\Livewire\Opname;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class OpnameComponent extends Component
{
    public function render()
    {
        $user = Auth::user();
        if (!$user->hasPermissionTo('Opname')){
            return abort(401);
        }
        return view('livewire.opname.opname-component');
    }
}
