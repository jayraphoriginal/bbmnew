<?php

namespace App\Http\Livewire\Laporan;

use Livewire\Component;

use Illuminate\Support\Facades\Auth;
use LivewireUI\Modal\ModalComponent;

class LaporanPembelianBiayaModal extends ModalComponent
{


    public $tgl_awal, $tgl_akhir;

    public function render()
    {
        $user = Auth::user();
        if (!$user->hasPermissionTo('Laporan Pembelian Biaya')){
            return abort(401);
        }
        return view('livewire.laporan.laporan-pembelian-biaya-modal');
    }
}
