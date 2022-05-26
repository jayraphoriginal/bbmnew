<?php

namespace App\Http\Livewire\Barang;

use App\Models\Barang;
use App\Models\Satuan;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use LivewireUI\Modal\ModalComponent;

class BarangModal extends ModalComponent
{
    use LivewireAlert;

    public Barang $barang;
    public $editmode, $barang_id;
    public $satuan;

    protected $listeners = ['selectsatuan' => 'selectsatuan'];

    protected $rules=[
        'barang.nama_barang' => 'required',
        'barang.tipe' => 'required',
        'barang.merk' => 'required',
        'barang.satuan_id' => 'required'
    ];

    public function mount(){

        if ($this->editmode=='edit') {
            $this->barang = Barang::find($this->barang_id);
            $this->satuan = Satuan::find($this->barang->satuan_id)->satuan;
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

    public function save(){

        $this->validate();

        $this->barang->save();

        $this->closeModal();

        $this->alert('success', 'Save Success', [
            'position' => 'center'
        ]);

        $this->emitTo('barang.barang-table', 'pg:eventRefresh-default');

    }
}
