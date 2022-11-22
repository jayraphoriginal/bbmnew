<?php

namespace App\Http\Livewire\Mutubeton;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class MutubetonComponent extends Component
{
    public function render()
    {
        $user = Auth::user();
        if (!$user->hasPermissionTo('Mutubeton')){
            return abort(401);
        }
        return view('livewire.mutubeton.mutubeton-component');
    }
}
