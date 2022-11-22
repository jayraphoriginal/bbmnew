<?php

namespace App\Http\Livewire\Supplier;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class SupplierComponent extends Component
{
    public function render()
    {
        $user = Auth::user();
        if (!$user->hasPermissionTo('Supplier')){
            return abort(401);
        }
        return view('livewire.supplier.supplier-component');
    }
}
