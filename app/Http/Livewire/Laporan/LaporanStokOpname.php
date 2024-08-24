<?php

namespace App\Http\Livewire\Laporan;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use LivewireUI\Modal\ModalComponent;

class LaporanStokOpname extends ModalComponent
{
    public $tgl_awal, $tgl_akhir;
    public $barang_id, $barang;

    protected $listeners = [
        'selectbarang' => 'selectbarang',
    ];

    public function selectbarang($id){
        $this->barang_id=$id;
    }
    public function render()
    {
        $user = Auth::user();
        if (!$user->hasPermissionTo('Laporan Stok Opname')){
            return abort(401);
        }
        return view('livewire.laporan.laporan-stok-opname');
    }
}
