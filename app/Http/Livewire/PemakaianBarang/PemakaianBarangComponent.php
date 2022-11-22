<?php

namespace App\Http\Livewire\PemakaianBarang;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class PemakaianBarangComponent extends Component
{
    public function render()
    {
        $user = Auth::user();
        if (!$user->hasPermissionTo('Pemakaian Barang')){
            return abort(401);
        }
        return view('livewire.pemakaian-barang.pemakaian-barang-component');
    }
}
