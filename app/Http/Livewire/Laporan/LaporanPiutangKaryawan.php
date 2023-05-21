<?php

namespace App\Http\Livewire\Laporan;

use Illuminate\Support\Facades\Auth;
use LivewireUI\Modal\ModalComponent;

class LaporanPiutangKaryawan extends ModalComponent
{
    public $tgl_awal, $tgl_akhir;
    public function render()
    {
        $user = Auth::user();
        if (!$user->hasPermissionTo('Laporan Rekap Piutang Karyawan')){
            return abort(401);
        }
        return view('livewire.laporan.laporan-piutang-karyawan');
    }
}
