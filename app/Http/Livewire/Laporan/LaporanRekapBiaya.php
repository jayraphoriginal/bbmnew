<?php

namespace App\Http\Livewire\Laporan;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use LivewireUI\Modal\ModalComponent;

class LaporanRekapBiaya extends ModalComponent
{
    public $tgl_awal, $tgl_akhir;
    public function render()
    {
        $user = Auth::user();
        if (!$user->hasPermissionTo('Laporan Rekap Biaya')){
            return abort(401);
        }
        return view('livewire.laporan.laporan-rekap-biaya');
    }
}
