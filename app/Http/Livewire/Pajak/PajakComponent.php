<?php

namespace App\Http\Livewire\Pajak;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class PajakComponent extends Component
{
    public function render()
    {
        
        $user = Auth::user();
        if (!$user->hasPermissionTo('Pajak')){
            return abort(401);
        }

        return view('livewire.pajak.pajak-component');
    }
}
