<?php

namespace App\Http\Livewire\Bbm;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class PenambahanBbmComponent extends Component
{
    public function render()
    {
        $user = Auth::user();
        if (!$user->hasPermissionTo('Tambahan BBM')){
            return abort(401);
        }
        return view('livewire.bbm.penambahan-bbm-component');
    }
}
