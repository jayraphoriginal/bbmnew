<?php

namespace App\Http\Livewire\Coa;

use App\Models\Coa;
use Livewire\Component;

class CoaSelect extends Component
{
    public $search;
    public $coa;
    public $deskripsi;

    protected $listeners = ['selectdata' => 'selectDeskripsi'];

    public function mount($deskripsi)
    {
        $this->deskripsi=$deskripsi;
    }

    public function resetdata()
    {
        $this->search = '';
        $this->coa = [];
    }

    public function selectdata($id)
    {
        $coa = Coa::find($id);
        $this->deskripsi = $coa->kode_akun.' - '.$coa->nama_akun;
        $this->emitTo('jurnal.jurnal-manual-detail-modal','selectcoa', $id);
    }

    public function selectDeskripsi($id){
        $coa = Coa::find($id);
        $this->deskripsi = $coa->kode_akun.' - '.$coa->nama_akun;
    }

    public function updatedSearch()
    {
        $this->coa = Coa::where('nama_akun', 'like', '%' . $this->search . '%')
            ->where('level',5)
            ->orderBy('kode_akun')
            ->get();
    }

    public function render()
    {
        return view('livewire.coa.coa-select');
    }
}
