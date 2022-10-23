<?php

namespace App\Http\Livewire\Alat;

use App\Models\Alat;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use LivewireUI\Modal\ModalComponent;

class AlatModal extends ModalComponent
{
    use LivewireAlert;

    public Alat $alat;
    public $editmode='';
    public $alat_id;

    protected function rules() {
        return [
            'alat.nama_alat' => 'required|min:2',
        ];
    }

    public function mount(){
        if ($this->editmode=='edit') {
            $this->alat = Alat::find($this->alat_id);
        }else{
            $this->alat = new Alat();
        }
    }

    public function save(){

        $this->validate();

        $this->alat->save();

        $this->closeModal();

        $this->alert('success', 'Save Success', [
            'position' => 'center'
        ]);

        $this->emitTo('alat.alat-table', 'pg:eventRefresh-default');

    }

    public function render()
    {
        return view('livewire.alat.alat-modal');
    }
}
