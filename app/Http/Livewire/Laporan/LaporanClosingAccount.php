<?php

namespace App\Http\Livewire\Laporan;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use LivewireUI\Modal\ModalComponent;

class LaporanClosingAccount extends ModalComponent
{
    public $tahun, $bulan;
    public function render()
    {
        $user = Auth::user();
        if (!$user->hasPermissionTo('Laporan Closing')){
            return abort(401);
        }
        return view('livewire.laporan.laporan-closing-account');
    }
}
