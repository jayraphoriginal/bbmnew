<?php

namespace App\Http\Livewire\Sewa;

use App\Models\Itemsewa;
use App\Models\Satuan;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use LivewireUI\Modal\ModalComponent;

class ItemsewaModal extends ModalComponent
{
    use LivewireAlert;

    public Itemsewa $itemsewa;
    public $editmode, $itemsewa_id;
    public $satuan;

    protected $listeners = ['selectsatuan' => 'selectsatuan'];

    protected $rules=[
        'itemsewa.nama_item' => 'required',
        'itemsewa.harga_intax' => 'required',
        'itemsewa.tipe' => 'required',
        'itemsewa.satuan_id' => 'required',
    ];

    public function mount(){

        if ($this->editmode=='edit') {
            $this->itemsewa = Itemsewa::find($this->itemsewa_id);
            $this->satuan = Satuan::find($this->itemsewa->satuan_id)->satuan;
        }else{
            $this->itemsewa = new Itemsewa();
        }

    }

    public function selectsatuan($id){
        $this->itemsewa->satuan_id=$id;
    }

    public function save(){

        $this->validate();

        $this->itemsewa->harga_intax = str_replace(',', '', $this->itemsewa->harga_intax);

        $this->itemsewa->save();

        $this->closeModal();

        $this->alert('success', 'Save Success', [
            'position' => 'center'
        ]);

        $this->emitTo('sewa.itemsewa-table', 'pg:eventRefresh-default');

    }

    public function render()
    {
        return view('livewire.sewa.itemsewa-modal');
    }
}
