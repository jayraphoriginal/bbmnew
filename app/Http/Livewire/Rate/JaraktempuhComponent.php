<?php

namespace App\Http\Livewire\Rate;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class JaraktempuhComponent extends Component
{
    public function render()
    {
        $user = Auth::user();
        if (!$user->hasPermissionTo('Jarak Tempuh')){
            return abort(401);
        }
        return view('livewire.rate.jaraktempuh-component');
    }
}
