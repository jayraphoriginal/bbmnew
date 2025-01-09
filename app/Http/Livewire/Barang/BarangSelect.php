<?php

namespace App\Http\Livewire\Barang;

use App\Models\Barang;
use Livewire\Component;

class BarangSelect extends Component
{
    public $search;
    public $barang;
    public $deskripsi;

    protected $listeners = ['selectdata' => 'selectDeskripsi'];

    public function mount($deskripsi)
    {
        $this->deskripsi=$deskripsi;
    }

    public function resetdata()
    {
        $this->search = '';
        $this->barang = [];
    }

    public function selectdata($id)
    {
        $this->deskripsi = Barang::find($id)->nama_barang;
        $this->emitTo('pembelian.purchaseorder-detail-modal','selectbarang', $id);
        $this->emitTo('penjualan.penjualan-retail-modal','selectbarang', $id);
        $this->emitTo('mutubeton.komposisi-modal','selectbarang', $id);
        $this->emitTo('produksi.produksi-detail-modal','selectbarang', $id);
        $this->emitTo('produksi.produksi-modal','selectbarang', $id);
        $this->emitTo('penjualan.penjualan-detail-modal','selectbarang', $id);
        $this->emitTo('penjualan.penjualan-detail-edit-modal','selectbarang', $id);
        $this->emitTo('pemakaian-barang.pemakaian-barang-modal','selectbarang', $id);
        $this->emitTo('bbm.pengisian-bbm-stok-modal','selectbarang', $id);
        $this->emitTo('laporan.laporan-kartustok','selectbarang', $id);
        $this->emitTo('laporan.laporan-kartu-stok-harian','selectbarang', $id);
        $this->emitTo('laporan.laporan-pembelian-barang','selectbarang', $id);
        $this->emitTo('opname.opname-detail-modal','selectbarang', $id);
        $this->emitTo('laporan.laporan-pemakaian-barang-beban','selectbarang', $id);
        $this->emitTo('rekalkulasi.rekalkulasiper-barang-modal','selectbarang', $id);
        $this->emitTo('produk-turunan.produk-turunan-modal','selectbarang', $id);
        $this->emitTo('produk-turunan.komposisi-produkturunan-modal','selectbarang', $id);
        $this->emitTo('laporan.laporan-stok-opname','selectbarang', $id);
        $this->emitTo('laporan.laporan-produksi-produkturunan','selectbarang', $id);
        $this->emitTo('laporan.laporan-penjualan-barang','selectbarang', $id);
       // $this->emitTo('produksi.produksi-new-modal','selectbarang', $id);
    }

    public function selectDeskripsi($id){
        $this->deskripsi = Barang::find($id)->nama_barang;
    }

    public function updatedSearch()
    {
        $this->barang = Barang::where('nama_barang', 'like', '%' . $this->search . '%')
            ->get();
    }


    public function render()
    {
        return view('livewire.barang.barang-select');
    }
}
