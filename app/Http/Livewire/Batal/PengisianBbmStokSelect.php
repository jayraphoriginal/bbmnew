<?php

namespace App\Http\Livewire\Batal;

use App\Models\PengisianBbmStok;
use Livewire\Component;

class PengisianBbmStokSelect extends Component
{
    public $search;
    public $pengisianbbmstok;
    public $deskripsi;

    protected $listeners = ['selectdata' => 'selectDeskripsi'];

    public function mount($deskripsi)
    {
        $this->deskripsi=$deskripsi;
    }

    public function resetdata()
    {
        $this->search = '';
        $this->pengisianbbmstok = [];
    }

    public function selectdata($id)
    {
        $pengisianbbmstok = PengisianBbmStok::find($id);
        $this->deskripsi = $pengisianbbmstok->tgl_pengisian.' - '.$pengisianbbmstok->keterangan.' - '.number_format($pengisianbbmstok->total,0,',','.');
        $this->emitTo('batal.batal-pengisian-bbm-stok','selectid', $id);
    }

    public function updatedSearch()
    {
        $this->pengisianbbmstok = PengisianBbmStok::where('keterangan', 'like', '%' . $this->search . '%')
            ->get();
    }

    public function selectDeskripsi($id){
        $pengisianbbmstok = PengisianBbmStok::find($id);
        $this->deskripsi = $pengisianbbmstok->tgl_pengisian.' - '.$pengisianbbmstok->keterangan.' - '.number_format($pengisianbbmstok->total,0,',','.');
    }

    public function render()
    {
        return view('livewire.batal.pengisian-bbm-stok-select');
    }
}
