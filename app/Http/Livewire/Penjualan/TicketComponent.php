<?php

namespace App\Http\Livewire\Penjualan;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class TicketComponent extends Component
{
    
    public function render()
    {
        $user = Auth::user();
        if (!$user->hasPermissionTo('Ticket')){
            return abort(401);
        }
        return view('livewire.penjualan.ticket-component');
    }
}
