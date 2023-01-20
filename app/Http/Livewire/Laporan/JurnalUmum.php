<?php

namespace App\Http\Livewire\Laporan;

use App\Models\Coa;
use LivewireUI\Modal\ModalComponent;

class JurnalUmum extends ModalComponent
{

    public $tgl_awal, $tgl_akhir, $coa_id, $coa;

    protected $listeners = [
        'selectcoa' => 'selectcoa',
    ];

    public function selectcoa($id){
        $this->coa_id=$id;
        $coa = Coa::find($this->coa_id);
        $this->coa = $coa->kode_akun.' - '.$coa->nama_akun;
    }

    public function render()
    {
        return view('livewire.laporan.jurnal-umum');
    }
}
