<?php

namespace App\Http\Livewire\Barang;

use App\Models\BahanBakar;
use App\Models\Satuan;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use LivewireUI\Modal\ModalComponent;

class BahanbakarModal extends ModalComponent
{
    use LivewireAlert;

    public BahanBakar $bahanBakar;
    public $editmode, $bahanbakar_id;
    public $satuan;

    protected $listeners = ['selectsatuan' => 'selectsatuan'];

    protected $rules=[
        'bahanBakar.bahan_bakar' => 'required',
        'bahanBakar.harga_beli' => 'required',
        'bahanBakar.harga_claim' => 'required',
        'bahanBakar.satuan_id' => 'required'
    ];

    public function mount(){

        if ($this->editmode=='edit') {
            $this->bahanBakar = BahanBakar::find($this->bahanbakar_id);
            $this->satuan = Satuan::find($this->bahanBakar->satuan_id)->satuan;
        }else{
            $this->bahanBakar = new BahanBakar();
        }

    }

    public function selectsatuan($id){
        $this->bahanBakar->satuan_id=$id;
    }

    public function save(){

        $this->validate();

        $this->bahanBakar->harga_beli = str_replace(',', '', $this->bahanBakar->harga_beli);

        $this->bahanBakar->harga_claim = str_replace(',', '', $this->bahanBakar->harga_claim);

        $this->bahanBakar->save();

        $this->closeModal();

        $this->alert('success', 'Save Success', [
            'position' => 'center'
        ]);

        $this->emitTo('barang.bahanbakar-table', 'pg:eventRefresh-default');

    }

    public function render()
    {
        return view('livewire.barang.bahanbakar-modal');
    }
}
