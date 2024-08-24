<?php

namespace App\Http\Livewire\ProdukTurunan;

use App\Models\Barang;
use App\Models\KomposisiTurunan;
use App\Models\Produkturunan;
use App\Models\Satuan;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use LivewireUI\Modal\ModalComponent;

class KomposisiProdukturunanModal extends ModalComponent
{
    use LivewireAlert;

    public KomposisiTurunan $komposisi;
    public $editmode, $komposisi_id;
    public $satuan, $barang, $deskripsi;
    public $produkturunan_id;

    protected $listeners = [
        'selectbarang' => 'selectbarang',
    ];

    protected $rules=[
        'komposisi.produkturunan_id' => 'required',
        'komposisi.barang_id' => 'required',
        'komposisi.jumlah' => 'required',
        'komposisi.satuan_id' => 'required',
        'komposisi.tipe' => 'required'
    ];

    public function mount(){

        $user = Auth::user();
        if (!$user->hasPermissionTo('Komposisi')){
            return abort(401);
        }

        if ($this->editmode=='edit') {
            
            $this->komposisi = KomposisiTurunan::find($this->komposisi_id);
            $this->deskripsi = ProdukTurunan::find($this->komposisi->produkturunan_id)->deskripsi;
            $this->barang = Barang::find($this->komposisi->barang_id)->nama_barang;
            $this->satuan = Satuan::find($this->komposisi->satuan_id)->satuan;
        }else{
            $this->komposisi = new KomposisiTurunan();
            $this->komposisi->produkturunan_id = $this->produkturunan_id;
            $this->deskripsi = Produkturunan::find($this->produkturunan_id)->deskripsi;
        }
        
    }

    public function selectbarang($id){
        $this->komposisi->barang_id=$id;
        $barang = Barang::find($id);
        $this->komposisi->satuan_id = $barang->satuan_id;
        $this->satuan = Satuan::find($barang->satuan_id)->satuan;
    }

    public function save(){

        $this->validate();

        $this->komposisi->jumlah = str_replace(',', '', $this->komposisi->jumlah);

        $this->komposisi->save();

        $this->closeModal();

        $this->alert('success', 'Save Success', [
            'position' => 'center'
        ]);

        $this->emitTo('produk-turunan.komposisi-produkturunan-table', 'pg:eventRefresh-default');

    }

    public function render()
    {
        return view('livewire.produk-turunan.komposisi-produkturunan-modal');
    }
}
