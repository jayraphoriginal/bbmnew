<?php

namespace App\Http\Livewire\Driver;

use App\Models\Driver;
use Livewire\Component;

class DriverSelect extends Component
{
    public $search;
    public $driver;
    public $deskripsi;

    protected $listeners = ['selectdata' => 'selectDeskripsi'];

    public function mount($deskripsi)
    {
        $this->deskripsi=$deskripsi;
    }

    public function resetdata()
    {
        $this->search = '';
        $this->driver = [];
    }

    public function selectdata($id)
    {
        $this->deskripsi = Driver::find($id)->nama_driver;
        $this->emitTo('kendaraan.kendaraan-modal','selectdriver', $id);
        $this->emitTo('penjualan.ticket-modal','selectdriver', $id);
        $this->emitTo('penjualan.concretepump-modal','selectdriver', $id);
        $this->emitTo('sewa.timesheet-modal','selectdriver', $id);
        $this->emitTo('produksi.produksi-modal','selectdriver', $id);
        $this->emitTo('bbm.pengisian-bbm-modal','selectdriver', $id);
        $this->emitTo('bbm.penambahan-bbm-modal','selectdriver', $id);
        $this->emitTo('laporan.rekap-gajiper-driver-modal','selectdriver', $id);
    }

    public function selectDeskripsi($id){
        $this->deskripsi = Driver::find($id)->nama_driver;
    }

    public function updatedSearch()
    {
        $this->driver = Driver::where('nama_driver', 'like', '%' . $this->search . '%')
            ->get();
    }

    public function render()
    {
        return view('livewire.driver.driver-select');
    }
}
