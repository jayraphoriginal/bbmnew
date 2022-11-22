<?php

namespace App\Http\Livewire\Driver;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class DriverComponent extends Component
{
    public function render()
    {
        $user = Auth::user();
        if (!$user->hasPermissionTo('Driver')){
            return abort(401);
        }
        return view('livewire.driver.driver-component');
    }
}
