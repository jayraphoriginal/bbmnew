<?php

namespace App\Http\Livewire\Rate;

use App\Models\JarakTempuh;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use LivewireUI\Modal\ModalComponent;

class JaraktempuhModal extends ModalComponent
{

    use LivewireAlert;

    public JarakTempuh $jarakTempuh;
    public $editmode='';
    public $jaraktempuh_id;

    protected function rules() {
        return [
            'jarakTempuh.awal' => 'required',
            'jarakTempuh.akhir' => 'required',
        ];
    }

    public function mount(){
        if ($this->editmode=='edit') {
            $this->jarakTempuh = JarakTempuh::find($this->jaraktempuh_id);
        }else{
            $this->jarakTempuh = new JarakTempuh();
        }
    }

    public function save(){

        $this->validate();

        $this->jarakTempuh->awal = str_replace(',', '', $this->jarakTempuh->awal);

        $this->jarakTempuh->akhir = str_replace(',', '', $this->jarakTempuh->akhir);


        $this->jarakTempuh->save();

        $this->closeModal();

        $this->alert('success', 'Save Success', [
            'position' => 'center'
        ]);

        $this->emitTo('rate.jaraktempuh-table', 'pg:eventRefresh-default');

    }

    public function render()
    {
        return view('livewire.rate.jaraktempuh-modal');
    }
}
