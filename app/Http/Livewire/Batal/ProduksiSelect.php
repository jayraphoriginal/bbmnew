<?php

namespace App\Http\Livewire\Batal;

use App\Models\VProduksiProdukturunan;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ProduksiSelect extends Component
{

    public $search;
    public $produksi;
    public $deskripsi;

    protected $listeners = ['selectdata' => 'selectDeskripsi'];

    public function mount($deskripsi)
    {
        $this->deskripsi=$deskripsi;
    }

    public function resetdata()
    {
        $this->search = '';
        $this->produksi = [];
    }

    public function selectdata($id)
    {
        $produksi = VProduksiProdukturunan::find($id);
        $this->deskripsi = date_format(date_create($produksi->tanggal),'d/M/Y').' - '.$produksi->keterangan;
        $this->emitTo('batal.batal-produksi','selectproduksi', $id);
    }

    public function selectDeskripsi($id){
        $produksi = VProduksiProdukturunan::find($id);
        $this->deskripsi = date_format(date_create($produksi->tanggal),'d/M/Y').' - '.$produksi->keterangan;
    }

    public function updatedSearch()
    {
        $this->produksi = VProduksiProdukturunan::where(
            function($query) {
                return $query
                       ->where( 'keterangan', 'LIKE', '%'.$this->search.'%')
                       ->Where('tanggal','>=',DB::raw("DATEADD(month, -2, GETDATE())"));
               })
            ->orwhere(function($query) {
                return $query
                       ->where( 'nama_barang', 'LIKE', '%'.$this->search.'%')
                       ->Where('tanggal','>=',DB::raw("DATEADD(month, -2, GETDATE())"));
               })
               
            ->get();
    }

    public function render()
    {
        return view('livewire.batal.produksi-select');
    }
}
