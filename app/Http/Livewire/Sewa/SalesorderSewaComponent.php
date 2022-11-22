<?php

namespace App\Http\Livewire\Sewa;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class SalesorderSewaComponent extends Component
{

    
    public function render()
    {
        $user = Auth::user();
        if (!$user->hasPermissionTo('Sales Order Sewa')){
            return abort(401);
        }
        return view('livewire.sewa.salesorder-sewa-component');
    }
}
