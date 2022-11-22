<?php

namespace App\Http\Livewire\PengeluaranBiaya;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class PengeluaranBiayaComponent extends Component
{

    public function render()
    {
        $user = Auth::user();
        if (!$user->hasPermissionTo('Pengeluaran Biaya')){
            return abort(401);
        }
        return view('livewire.pengeluaran-biaya.pengeluaran-biaya-component');
    }
}
