<?php

namespace App\Http\Livewire\Mutubeton;

use App\Models\Barang;
use App\Models\Komposisi;
use App\Models\Mutubeton;
use App\Models\Satuan;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use LivewireUI\Modal\ModalComponent;

class KomposisiModal extends ModalComponent
{
    use LivewireAlert;

    public Komposisi $komposisi;
    public $editmode, $komposisi_id;
    public $satuan, $barang, $kode_mutu;
    public $mutubeton_id;

    protected $listeners = [
        'selectbarang' => 'selectbarang',
    ];

    protected $rules=[
        'komposisi.mutubeton_id' => 'required',
        'komposisi.barang_id' => 'required',
        'komposisi.jumlah' => 'required',
        'komposisi.satuan_id' => 'required',
        'komposisi.tipe' => 'required'
    ];

    public function mount($komposisi_id){

        if ($this->editmode=='edit') {
            $this->komposisi = Komposisi::find($this->komposisi_id);
            $this->barang = Barang::find($this->komposisi->barang_id)->nama_barang;
            $this->satuan = Satuan::find($this->komposisi->satuan_id)->satuan;
        }else{
            $this->komposisi = new Komposisi();
            $this->komposisi->mutubeton_id = $this->mutubeton_id;
        }
        $this->kode_mutu = Mutubeton::find($this->komposisi->mutubeton_id)->kode_mutu;
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

        $this->emitTo('mutubeton.komposisi-table', 'pg:eventRefresh-default');

    }
    public function render()
    {
        return view('livewire.mutubeton.komposisi-modal');
    }
}
