<?php

namespace App\Http\Livewire\Laporan;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use LivewireUI\Modal\ModalComponent;

class LaporanPenjualanHarian extends ModalComponent
{
    public $tgl;

    public function mount(){
        $this->tgl = date('Y-m-d');
    }

    public function render()
    {
        $user = Auth::user();
        if (!$user->hasPermissionTo('Laporan Penjualan Beton')){
            return abort(401);
        }
        return view('livewire.laporan.laporan-penjualan-harian');
    }
}
