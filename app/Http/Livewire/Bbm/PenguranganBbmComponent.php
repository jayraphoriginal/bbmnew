<?php

namespace App\Http\Livewire\Bbm;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class PenguranganBbmComponent extends Component
{
    public function render()
    {
        $user = Auth::user();
        if (!$user->hasPermissionTo('Tambahan BBM')){
            return abort(401);
        }
        return view('livewire.bbm.pengurangan-bbm-component');
    }
}
