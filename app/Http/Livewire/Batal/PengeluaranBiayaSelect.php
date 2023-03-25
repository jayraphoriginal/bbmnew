<?php

namespace App\Http\Livewire\Batal;

use App\Models\PengeluaranBiaya;
use Livewire\Component;

class PengeluaranBiayaSelect extends Component
{
    public $search;
    public $pengeluaranbiaya;
    public $deskripsi;

    protected $listeners = ['selectdata' => 'selectDeskripsi'];

    public function mount($deskripsi)
    {
        $this->deskripsi=$deskripsi;
    }

    public function resetdata()
    {
        $this->search = '';
        $this->pengeluaranbiaya = [];
    }

    public function selectdata($id)
    {
        $pengeluaranbiaya = PengeluaranBiaya::find($id);
        $this->deskripsi = $pengeluaranbiaya->ket.' - '.number_format($pengeluaranbiaya->total,0,',','.');
        $this->emitTo('batal.batal-pengeluaran-biaya','selectid', $id);
    }

    public function selectDeskripsi($id){
        $pengeluaranbiaya = PengeluaranBiaya::find($id);
        $this->deskripsi = $pengeluaranbiaya->ket.' - '.number_format($pengeluaranbiaya->total,0,',','.');
    }

    public function updatedSearch()
    {
        $this->pengeluaranbiaya = PengeluaranBiaya::where('ket', 'like', '%' . $this->search . '%')
            ->get();
    }
    public function render()
    {
        return view('livewire.batal.pengeluaran-biaya-select');
    }
}
