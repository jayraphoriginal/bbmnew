<?php

namespace App\Http\Livewire\Satuan;

use App\Models\Satuan;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use LivewireUI\Modal\ModalComponent;

class SatuanModal extends ModalComponent
{
    use LivewireAlert;

    public Satuan $satuan;
    public $editmode='';
    public $satuan_id;

    protected function rules() {
        return [
            'satuan.satuan' => 'required|min:2',
        ];
    }

    public function mount(){
        if ($this->editmode=='edit') {
            $this->satuan = Satuan::find($this->satuan_id);
        }else{
            $this->satuan = new Satuan();
        }
    }

    public function render()
    {
        return view('livewire.satuan.satuan-modal');
    }

    public function save(){

        $this->validate();

        $this->satuan->save();

        $this->closeModal();

        $this->alert('success', 'Save Success', [
            'position' => 'center'
        ]);

        $this->emitTo('satuan.satuan-table', 'pg:eventRefresh-default');

    }
}
