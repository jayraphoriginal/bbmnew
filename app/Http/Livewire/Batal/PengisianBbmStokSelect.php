<?php

namespace App\Http\Livewire\Batal;

use App\Models\PengisianBbmStok;
use App\Models\VPengisianBbmStok;
use Illuminate\Support\Facades\DB;
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
        $pengisianbbmstok = VPengisianBbmStok::find($id);
        $this->deskripsi = $pengisianbbmstok->alken.' - '.$pengisianbbmstok->tgl_pengisian.' - '.$pengisianbbmstok->keterangan;
        $this->emitTo('batal.batal-pengisian-bbm-stok','selectid', $id);
    }

    public function updatedSearch()
    {
        $this->pengisianbbmstok = VPengisianBbmStok::
        where(
            function($query) {
                return $query
                       ->where( 'keterangan', 'LIKE', '%'.$this->search.'%')
                       ->Where('tgl_pengisian','>=',DB::raw("DATEADD(month, -2, GETDATE())"));
               })
            ->orwhere(function($query) {
                return $query
                       ->where( 'alken', 'LIKE', '%'.$this->search.'%')
                       ->Where('tgl_pengisian','>=',DB::raw("DATEADD(month, -2, GETDATE())"));
               })
            ->get();
    }

    public function selectDeskripsi($id){
        $pengisianbbmstok = VPengisianBbmStok::find($id);
        $this->deskripsi = $pengisianbbmstok->alken.' - '.$pengisianbbmstok->tgl_pengisian.' - '.$pengisianbbmstok->keterangan;
    }

    public function render()
    {
        return view('livewire.batal.pengisian-bbm-stok-select');
    }
}
