<?php

namespace App\Http\Livewire\Alat;

use App\Models\Alat;
use Livewire\Component;

class AlatSelect extends Component
{
    public $search;
    public $alat;
    public $deskripsi;

    protected $listeners = ['selectdata' => 'selectDeskripsi'];

    public function mount($deskripsi)
    {
        $this->deskripsi=$deskripsi;
    }

    public function resetdata()
    {
        $this->search = '';
        $this->alat = [];
    }

    public function selectdata($id)
    {
        $this->deskripsi = Alat::find($id)->nama_alat;
        $this->emitTo('pembelian.purchaseorder-modal','selectalat', $id);
        $this->emitTo('pengeluaran-biaya.pengeluaran-biaya-detail-modal','selectalat', $id);
        $this->emitTo('pemakaian-barang.pemakaian-barang-modal','selectalat', $id);
        $this->emitTo('laporan.laporan-pemakaianper-beban','selectalat', $id);
        $this->emitTo('laporan.laporan-pemakaian-barang-beban','selectalat', $id);
    }

    public function selectDeskripsi($id){
        $this->deskripsi = Alat::find($id)->nama_alat;
    }

    public function updatedSearch()
    {
        $this->alat = Alat::where('nama_alat', 'like', '%' . $this->search . '%')
            ->get();
    }

    public function render()
    {
        return view('livewire.alat.alat-select');
    }
}
