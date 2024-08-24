<?php

namespace App\Http\Livewire\ProdukTurunan;

use App\Models\Barang;
use App\Models\Produkturunan;
use Livewire\Component;
use LivewireUI\Modal\ModalComponent;

class KomposisiProdukturunanComponent extends ModalComponent
{

    public $produkturunan_id, $produk_turunan, $deskripsi;

    public function mount($produkturunan_id){
        $this->produkturunan_id = $produkturunan_id;
        $produkturunan = Produkturunan::find($produkturunan_id);
        $barang = Barang::find($produkturunan->barang_id);
        $this->produk_turunan = $barang->nama_barang;
        $this->deskripsi = $produkturunan->deskripsi;
    }

    public function add(){
        $this->emit("openModal", "produk-turunan.komposisi-produkturunan-modal", ["produkturunan_id" => $this->produkturunan_id]);
    }


    public function render()
    {
        return view('livewire.produk-turunan.komposisi-produkturunan-component');
    }

    public static function modalMaxWidth(): string
    {
        return '7xl';
    }
}
