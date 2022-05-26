<?php

namespace App\Http\Livewire\Pajak;

use App\Models\Mpajak;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use LivewireUI\Modal\ModalComponent;

class PajakModal extends ModalComponent
{
    use LivewireAlert;

    public Mpajak $mpajak;
    public $editmode='';
    public $pajak_id;

    protected function rules() {
        return [
            'mpajak.jenis_pajak' => 'required',
            'mpajak.persen' => 'required',
        ];
    }

    public function mount(){
        if ($this->editmode=='edit') {
            $this->mpajak = Mpajak::find($this->pajak_id);
        }else{
            $this->mpajak = new Mpajak();
        }
    }

    public function save(){

        $this->validate();

        $this->mpajak->persen = str_replace('.', '', $this->mpajak->persen);
        $this->mpajak->persen = str_replace(',', '.', $this->mpajak->persen);

        $this->mpajak->save();

        $this->closeModal();

        $this->alert('success', 'Save Success', [
            'position' => 'center'
        ]);

        $this->emitTo('pajak.pajak-table', 'pg:eventRefresh-default');

    }

    public function render()
    {
        return view('livewire.pajak.pajak-modal');
    }
}
