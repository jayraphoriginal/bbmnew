<?php

namespace App\Http\Livewire\Bank;

use App\Models\Bank;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use LivewireUI\Modal\ModalComponent;

class BankModal extends ModalComponent
{
    use LivewireAlert;

    public Bank $bank;
    public $editmode='';
    public $bank_id;

    protected function rules() {
        return [
            'bank.kode_bank' => 'required',
            'bank.nama_bank' => 'required',
        ];
    }

    public function mount(){
        if ($this->editmode=='edit') {
            $this->bank = Bank::find($this->bank_id);
        }else{
            $this->bank = new Bank();
        }
    }

    public function save(){

        $this->validate();

        $this->bank->save();

        $this->closeModal();

        $this->alert('success', 'Save Success', [
            'position' => 'center'
        ]);

        $this->emitTo('bank.bank-table', 'pg:eventRefresh-default');

    }

    public function render()
    {
        return view('livewire.bank.bank-modal');
    }
}
