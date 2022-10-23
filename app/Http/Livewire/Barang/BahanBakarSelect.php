<?php

namespace App\Http\Livewire\Barang;

use App\Models\BahanBakar;
use Livewire\Component;

class BahanBakarSelect extends Component
{
    public $search;
    public $bahanbakar;
    public $deskripsi;

    protected $listeners = ['selectdata' => 'selectDeskripsi'];

    public function mount($deskripsi)
    {
        $this->deskripsi=$deskripsi;
    }

    public function resetdata()
    {
        $this->search = '';
        $this->bahanbakar = [];
    }

    public function selectdata($id)
    {
        $this->deskripsi = BahanBakar::find($id)->bahan_bakar;
        $this->emitTo('bbm.pengisian-bbm-modal','selectbahanbakar', $id);
        $this->emitTo('bbm.penambahan-bbm-modal','selectbahanbakar', $id);
    }

    public function selectDeskripsi($id){
        $this->deskripsi = BahanBakar::find($id)->bahan_bakar;
    }

    public function updatedSearch()
    {
        $this->bahanbakar = BahanBakar::where('bahan_bakar', 'like', '%' . $this->search . '%')
            ->get();
    }

    public function render()
    {
        return view('livewire.barang.bahan-bakar-select');
    }
}
