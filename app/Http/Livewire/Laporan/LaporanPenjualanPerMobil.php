<?php

namespace App\Http\Livewire\Laporan;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use LivewireUI\Modal\ModalComponent;

class LaporanPenjualanPerMobil extends ModalComponent
{
    public $tgl_awal, $tgl_akhir, $kendaraan_id, $kendaraan;

    protected $listeners = [
        'selectkendaraan' => 'selectkendaraan',
    ];

    public function selectkendaraan($id){
        $this->kendaraan_id=$id;
    }

    public function render()
    {
        $user = Auth::user();
        if (!$user->hasPermissionTo('Laporan Penjualan Beton per Mobil')){
            return abort(401);
        }
        return view('livewire.laporan.laporan-penjualan-per-mobil');
    }
}
