<?php

namespace App\Http\Livewire\Rate;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class RateComponent extends Component
{
    public function render()
    {
        $user = Auth::user();
        if (!$user->hasPermissionTo('Rate')){
            return abort(401);
        }
        return view('livewire.rate.rate-component');
    }
}
