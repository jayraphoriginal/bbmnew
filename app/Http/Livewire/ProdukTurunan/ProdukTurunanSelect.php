<?php

namespace App\Http\Livewire\ProdukTurunan;

use App\Models\Produkturunan;
use Livewire\Component;

class ProdukTurunanSelect extends Component
{

    public $search;
    public $produkturunan;
    public $deskripsi;

    protected $listeners = ['selectdata' => 'selectDeskripsi'];

    public function mount($deskripsi)
    {
        $this->deskripsi=$deskripsi;
    }

    public function resetdata()
    {
        $this->search = '';
        $this->produkturunan = [];
    }

    public function selectdata($id)
    {
        $this->deskripsi = Produkturunan::find($id)->deskripsi;
       //$this->emitTo('produk-turunan.produk-turunan-modal','selectprodukturunan', $id);
        $this->emitTo('produksi.produksi-new-modal','selectprodukturunan', $id);
    }

    public function selectDeskripsi($id){
        $this->deskripsi = Produkturunan::find($id)->deskripsi;
    }

    public function updatedSearch()
    {
        $this->produkturunan = Produkturunan::where('deskripsi', 'like', '%' . $this->search . '%')
            ->get();
    }

    public function render()
    {
        return view('livewire.produk-turunan.produk-turunan-select');
    }
}
