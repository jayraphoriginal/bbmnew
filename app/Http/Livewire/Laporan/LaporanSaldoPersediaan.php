<?php

namespace App\Http\Livewire\Laporan;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use LivewireUI\Modal\ModalComponent;

class LaporanSaldoPersediaan extends ModalComponent
{

    public $tgl_awal, $tgl_akhir;

    public function render()
    {
        $user = Auth::user();
        if (!$user->hasPermissionTo('Laporan Saldo Persediaan')){
            return abort(401);
        }
        return view('livewire.laporan.laporan-saldo-persediaan');
    }
}
