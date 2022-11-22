<?php

namespace App\Http\Livewire\Customer;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CustomerComponent extends Component
{
    public function render()
    {
        $user = Auth::user();
        if (!$user->hasPermissionTo('Customer')){
            return abort(401);
        }
        return view('livewire.customer.customer-component');
    }
}
