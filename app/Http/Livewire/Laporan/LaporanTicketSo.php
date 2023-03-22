<?php

namespace App\Http\Livewire\Laporan;

use Illuminate\Support\Facades\Auth;
use LivewireUI\Modal\ModalComponent;

class LaporanTicketSo extends ModalComponent
{ 
    public $tgl_awal, $tgl_akhir, $so_id;

    public function render()
    {
        $user = Auth::user();
        if (!$user->hasPermissionTo('PO Customer')){
            return abort(401);
        }
        return view('livewire.laporan.laporan-ticket-so');
    }
}
