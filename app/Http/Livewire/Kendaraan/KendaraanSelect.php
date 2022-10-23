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
        $this->emitTo('penjualan.concretepump-modal','selectkendaraan', $id);
        $this->emitTo('bbm.pengisian-bbm-modal','selectkendaraan', $id);
        $this->emitTo('bbm.penambahan-bbm-modal','selectkendaraan', $id);
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
