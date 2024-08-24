<?php

namespace App\Http\Livewire\Batal;

use App\Models\VPembelian;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class PembelianSelect extends Component
{

    public $search;
    public $pembelian;
    public $deskripsi;

    protected $listeners = ['selectdata' => 'selectDeskripsi'];

    public function mount($deskripsi)
    {
        $this->deskripsi=$deskripsi;
    }

    public function resetdata()
    {
        $this->search = '';
        $this->pembelian = [];
    }

    public function selectdata($id)
    {
        $pembelian = VPembelian::find($id);
        $this->deskripsi = $pembelian->nopo.' - '.$pembelian->nama_supplier;
        $this->emitTo('batal.batal-pembelian','selectpembelian', $id);
    }

    public function selectDeskripsi($id){
        $pembelian = VPembelian::find($id);
        $this->deskripsi = $pembelian->nopo.' - '.$pembelian->nama_supplier;
    }

    public function updatedSearch()
    {
        $this->pembelian = VPembelian::where(
            function($query) {
                return $query
                       ->where( 'nopo', 'LIKE', '%'.$this->search.'%')
                       ->Where('tgl_masuk','>=',DB::raw("DATEADD(month, -2, GETDATE())"));
               })
            ->orwhere(function($query) {
                return $query
                       ->where( 'nopo', 'LIKE', '%'.$this->search.'%')
                       ->Where('tgl_masuk','>=',DB::raw("DATEADD(month, -2, GETDATE())"));
               })
            ->get();
    }

    public function render()
    {
        return view('livewire.batal.pembelian-select');
    }
}
