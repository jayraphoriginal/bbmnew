<?php

namespace App\Http\Livewire\Laporan;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use LivewireUI\Modal\ModalComponent;

class LaporanPemakaianperBeban extends ModalComponent
{
    public $tgl_awal, $tgl_akhir, $tipe, $beban_id, $alat, $kendaraan;

    protected $listeners = [
        'selectkendaraan' => 'selectkendaraan',
        'selectalat' => 'selectalat'
    ];

    public function selectkendaraan($id){
        $this->beban_id=$id;
    }
    public function selectalat($id){
        $this->beban_id=$id;
    }

    public function render()
    {
        $user = Auth::user();
        if (!$user->hasPermissionTo('Laporan Pemakaian per Beban')){
            return abort(401);
        }
        return view('livewire.laporan.laporan-pemakaianper-beban');
    }
}
