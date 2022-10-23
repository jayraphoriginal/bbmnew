<?php

namespace App\Http\Livewire\Inventaris;

use App\Models\Golongan;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use LivewireUI\Modal\ModalComponent;

class GolonganModal extends ModalComponent
{
    use LivewireAlert;

    public Golongan $golongan;
    public $editmode='';
    public $golongan_id;

    protected function rules() {
        return [
            'golongan.kelompok' => 'required',
            'golongan.masa_manfaat' => 'required',
        ];
    }

    public function mount(){
        if ($this->editmode=='edit') {
            $this->golongan = Golongan::find($this->golongan_id);
        }else{
            $this->golongan = new Golongan();
        }
    }

    public function save(){

        $this->validate();

        $this->golongan->save();

        $this->closeModal();

        $this->alert('success', 'Save Success', [
            'position' => 'center'
        ]);

        $this->emitTo('inventaris.golongan-table', 'pg:eventRefresh-default');

    }
    public function render()
    {
        return view('livewire.inventaris.golongan-modal');
    }
}
