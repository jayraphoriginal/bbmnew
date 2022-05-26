<?php

namespace App\Http\Livewire\Satuan;

use App\Models\Satuan;
use Livewire\Component;

class SatuanSelect extends Component
{
    public $search;
    public $satuan;
    public $deskripsi;

    protected $listeners = ['selectdata' => 'selectDeskripsi'];

    public function mount($deskripsi)
    {
        $this->deskripsi=$deskripsi;
    }

    public function resetdata()
    {
        $this->search = '';
        $this->satuan = [];
    }

    public function selectdata($id)
    {
        $this->deskripsi = Satuan::find($id)->satuan;
        $this->emitTo('barang.barang-modal','selectsatuan', $id);
        $this->emitTo('barang.bahanbakar-modal','selectsatuan', $id);
        $this->emitTo('mutubeton.mutubeton-modal','selectsatuan', $id);
        $this->emitTo('sewa.itemsewa-modal','selectsatuan', $id);
    }

    public function selectDeskripsi($id){
        $this->deskripsi = Satuan::find($id)->satuan;
    }

    public function updatedSearch()
    {
        $this->satuan = Satuan::where('satuan', 'like', '%' . $this->search . '%')
            ->get();
    }

    public function render()
    {
        return view('livewire.satuan.satuan-select');
    }
}
