<?php

namespace App\Http\Livewire\Satuan;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class SatuanComponent extends Component
{
    public function render()
    {
        $user = Auth::user();
        if (!$user->hasPermissionTo('Satuan')){
            return abort(401);
        }
        return view('livewire.satuan.satuan-component');
    }
}
