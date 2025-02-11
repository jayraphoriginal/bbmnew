<?php

namespace App\Http\Livewire\Kendaraan;

use App\Models\Kendaraan;
use Livewire\Component;

class KendaraanSelect extends Component
{
    public $search;
    public $kendaraan;
    public $deskripsi;

    protected $listeners = ['selectdata' => 'selectDeskripsi'];

    public function mount($deskripsi)
    {
        $this->deskripsi=$deskripsi;
    }

    public function resetdata()
    {
        $this->search = '';
        $this->kendaraan = [];
    }

    public function selectdata($id)
    {
        $this->deskripsi = Kendaraan::find($id)->nopol;
        $this->emitTo('pembelian.purchaseorder-modal','selectkendaraan', $id);
        $this->emitTo('penjualan.ticket-modal','selectkendaraan', $id);
        $this->emitTo('produksi.ticket-produksi-modal','selectkendaraan', $id);
        $this->emitTo('penjualan.ticket-edit-modal','selectkendaraan', $id);
        $this->emitTo('penjualan.concretepump-modal','selectkendaraan', $id);
        $this->emitTo('bbm.pengisian-bbm-modal','selectkendaraan', $id);
        $this->emitTo('bbm.penambahan-bbm-modal','selectkendaraan', $id);
        $this->emitTo('pengeluaran-biaya.pengeluaran-biaya-detail-modal','selectkendaraan', $id);
        $this->emitTo('pemakaian-barang.pemakaian-barang-modal','selectkendaraan', $id);
        $this->emitTo('bbm.pengisian-bbm-stok-modal','selectkendaraan', $id);
        $this->emitTo('laporan.laporan-penjualan-per-mobil','selectkendaraan', $id);
        $this->emitTo('laporan.laporan-pemakaianper-beban','selectkendaraan', $id);
        $this->emitTo('laporan.laporan-pemakaian-barang-beban','selectkendaraan', $id);
    }

    public function selectDeskripsi($id){
        $this->deskripsi = Kendaraan::find($id)->nopol;
    }

    public function updatedSearch()
    {
        $this->kendaraan = Kendaraan::where('nopol', 'like', '%' . $this->search . '%')
            ->get();
    }

    public function render()
    {
        return view('livewire.kendaraan.kendaraan-select');
    }
}
