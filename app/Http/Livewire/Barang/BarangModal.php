<?php

namespace App\Http\Livewire\Barang;

use App\Models\Barang;
use App\Models\Kategori;
use App\Models\Satuan;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use LivewireUI\Modal\ModalComponent;

class BarangModal extends ModalComponent
{
    use LivewireAlert;

    public Barang $barang;
    public $editmode, $barang_id;
    public $satuan, $kategori;

    protected $listeners = [
        'selectsatuan' => 'selectsatuan',
        'selectkategori' => 'selectkategori',
    ];

    protected $rules=[
        'barang.nama_barang' => 'required',
        'barang.merk' => 'required',
        'barang.satuan_id' => 'required',
        'barang.stok_minimum' => 'required',
        'barang.kategori_id' => 'required'
    ];

    public function mount(){

        if ($this->editmode=='edit') {
            $this->barang = Barang::find($this->barang_id);
            $this->satuan = Satuan::find($this->barang->satuan_id)->satuan;
            $this->kategori = Kategori::find($this->barang->kategori_id)->kategori;
        }else{
            $this->barang = new Barang();
        }

    }

    public function render()
    {
        return view('livewire.barang.barang-modal');
    }

    public function selectsatuan($id){
        $this->barang->satuan_id=$id;
    }

    public function selectkategori($id){
        $this->barang->kategori_id=$id;
    }

    public function save(){

        $this->validate();

        $this->barang->stok_minimum = str_replace(',', '', $this->barang->stok_minimum);
        $this->barang->save();

        $this->closeModal();

        $this->alert('success', 'Save Success', [
            'position' => 'center'
        ]);

        $this->emitTo('barang.barang-table', 'pg:eventRefresh-default');

    }
}
