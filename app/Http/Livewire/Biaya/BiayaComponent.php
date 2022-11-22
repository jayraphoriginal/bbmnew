<?php

namespace App\Http\Livewire\Biaya;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class BiayaComponent extends Component
{
    public function render()
    {
        $user = Auth::user();
        if (!$user->hasPermissionTo('Biaya')){
            return abort(401);
        }
        return view('livewire.biaya.biaya-component');
    }
}
