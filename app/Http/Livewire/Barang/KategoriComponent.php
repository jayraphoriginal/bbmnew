<?php

namespace App\Http\Livewire\Barang;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class KategoriComponent extends Component
{
    public function render()
    {
        $user = Auth::user();
        if (!$user->hasPermissionTo('Kategori')){
            return abort(401);
        }
        return view('livewire.barang.kategori-component');
    }
}
