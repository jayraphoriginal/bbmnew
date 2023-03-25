<?php

namespace App\Http\Livewire\Laporan;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use LivewireUI\Modal\ModalComponent;

class TtDriver extends ModalComponent
{
    public $tgl_awal, $tgl_akhir, $driver_id, $driver;

    protected $listeners = [
        'selectdriver' => 'selectdriver',
    ];

    public function selectdriver($id){
        $this->driver_id=$id;
    }

    public function render()
    {
        $user = Auth::user();
        if (!$user->hasPermissionTo('TT Driver')){
            return abort(401);
        }
        return view('livewire.laporan.tt-driver');
    }
}
