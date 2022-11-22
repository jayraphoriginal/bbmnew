<?php

namespace App\Http\Livewire\Bbm;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class PengisianBbmComponent extends Component
{
    public function render()
    {
        $user = Auth::user();
        if (!$user->hasPermissionTo('Pengisian BBM')){
            return abort(401);
        }
        return view('livewire.bbm.pengisian-bbm-component');
    }
}
