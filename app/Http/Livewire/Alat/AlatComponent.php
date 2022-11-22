<?php

namespace App\Http\Livewire\Alat;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class AlatComponent extends Component
{
    
    public function render()
    {
        $user = Auth::user();
        if (!$user->hasPermissionTo('Alat')){
            return abort(401);
        }
        return view('livewire.alat.alat-component');
    }
}
