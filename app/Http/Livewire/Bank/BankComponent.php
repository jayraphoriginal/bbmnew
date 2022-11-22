<?php

namespace App\Http\Livewire\Bank;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class BankComponent extends Component
{
    public function render()
    {
        $user = Auth::user();
        if (!$user->hasPermissionTo('Bank')){
            return abort(401);
        }
        return view('livewire.bank.bank-component');
    }
}
