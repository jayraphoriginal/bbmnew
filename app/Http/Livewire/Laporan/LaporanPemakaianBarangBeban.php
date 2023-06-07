<?php

namespace App\Http\Livewire\Laporan;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use LivewireUI\Modal\ModalComponent;

class LaporanPemakaianBarangBeban extends ModalComponent
{
    public $tgl_awal, $tgl_akhir, $tipe, $beban_id, $alat, $kendaraan, $barang_id, $barang;
    protected $listeners = [
        'selectkendaraan' => 'selectkendaraan',
        'selectalat' => 'selectalat',
        'selectbarang' => 'selectbarang',
    ];

    public function selectkendaraan($id){
        $this->beban_id=$id;
    }
    public function selectalat($id){
        $this->beban_id=$id;
    }
    public function selectbarang($id){
        $this->barang_id = $id;
    }
    public function render()
    {
        $user = Auth::user();
        if (!$user->hasPermissionTo('Laporan Pemakaian per Barang')){
            return abort(401);
        }
        return view('livewire.laporan.laporan-pemakaian-barang-beban');
    }
}
