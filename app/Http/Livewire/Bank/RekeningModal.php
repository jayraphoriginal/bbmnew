<?php

namespace App\Http\Livewire\Bank;

use App\Models\Bank;
use App\Models\Rekening;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use LivewireUI\Modal\ModalComponent;

class RekeningModal extends ModalComponent
{

    use LivewireAlert;

    public Rekening $rekening;
    public $editmode, $rekening_id;
    public $bank;

    protected $listeners = ['selectbank' => 'selectbank'];

    protected $rules=[
        'rekening.norek' => 'required',
        'rekening.atas_nama' => 'required',
        'rekening.bank_id' => 'required'
    ];

    public function mount(){

        if ($this->editmode=='edit') {
            $this->rekening = Rekening::find($this->rekening_id);
            $this->bank = Bank::find($this->rekening->bank_id)->nama_bank;
        }else{
            $this->rekening = new Rekening();
        }

    }

    public function selectbank($id){
        $this->rekening->bank_id=$id;
    }

    public function save(){

        $this->validate();

        $this->rekening->save();

        $this->closeModal();

        $this->alert('success', 'Save Success', [
            'position' => 'center'
        ]);

        $this->emitTo('bank.rekening-table', 'pg:eventRefresh-default');

    }
    public function render()
    {
        return view('livewire.bank.rekening-modal');
    }
}
