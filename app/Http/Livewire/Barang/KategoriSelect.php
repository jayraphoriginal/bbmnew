<?php

namespace App\Http\Livewire\Barang;

use App\Models\Kategori;
use Livewire\Component;

class KategoriSelect extends Component
{
    public $search;
    public $kategori;
    public $deskripsi;

    protected $listeners = ['selectdata' => 'selectDeskripsi'];

    public function mount($deskripsi)
    {
        $this->deskripsi=$deskripsi;
    }

    public function resetdata()
    {
        $this->search = '';
        $this->kategori = [];
    }

    public function selectdata($id)
    {
        $this->deskripsi = Kategori::find($id)->kategori;
        $this->emitTo('barang.barang-modal','selectkategori', $id);
    }

    public function selectDeskripsi($id){
        $this->deskripsi = Kategori::find($id)->kategori;
    }

    public function updatedSearch()
    {
        $this->kategori = Kategori::where('kategori', 'like', '%' . $this->search . '%')
            ->get();
    }

    public function render()
    {
        return view('livewire.barang.kategori-select');
    }
}
