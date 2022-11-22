<?php

namespace App\Http\Livewire\Barang;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class BarangComponent extends Component
{
    public function render()
    {
        $user = Auth::user();
        if (!$user->hasPermissionTo('Barang')){
            return abort(401);
        }
        return view('livewire.barang.barang-component');
    }
}
