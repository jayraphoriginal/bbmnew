<?php

namespace App\Http\Livewire\Rate;

use App\Models\Rate;
use Livewire\Component;

class RateSelect extends Component
{
    public $search;
    public $rate;
    public $deskripsi;

    protected $listeners = ['selectdata' => 'selectDeskripsi'];

    public function mount($deskripsi)
    {
        $this->deskripsi=$deskripsi;
    }

    public function resetdata()
    {
        $this->search = '';
        $this->rate = [];
    }

    public function selectdata($id)
    {
        $rate = Rate::find($id);
        $this->deskripsi = $rate->tujuan.' - '.$rate->estimasi_jarak.' KM';
        $this->emitTo('penjualan.salesorder-detail-modal','selectrate', $id);
        $this->emitTo('penjualan.concretepump-modal','selectrate', $id);
        $this->emitTo('penjualan.ticket-modal','selectrate', $id);
    }

    public function selectDeskripsi($id){
        $rate = Rate::find($id);
        $this->deskripsi = $rate->tujuan.' - '.$rate->estimasi_jarak.' KM';
    }

    public function updatedSearch()
    {
        $this->rate = Rate::where('tujuan', 'like', '%' . $this->search . '%')
            ->get();
    }

    public function render()
    {
        return view('livewire.rate.rate-select');
    }
}
