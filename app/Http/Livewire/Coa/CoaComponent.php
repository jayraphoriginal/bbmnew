<?php

namespace App\Http\Livewire\Coa;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CoaComponent extends Component
{
    public function render()
    {
        $user = Auth::user();
        if (!$user->hasPermissionTo('COA')){
            return abort(401);
        }
        return view('livewire.coa.coa-component');
    }
}
