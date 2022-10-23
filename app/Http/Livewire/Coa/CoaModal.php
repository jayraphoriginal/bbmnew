<?php

namespace App\Http\Livewire\Coa;

use App\Models\Coa;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use LivewireUI\Modal\ModalComponent;

class CoaModal extends ModalComponent
{
    use LivewireAlert;

    public Coa $coa;
    public $editmode, $coa_id;

    protected $rules=[
        'coa.kode_akun' => 'required',
        'coa.nama_akun' => 'required',
        'coa.level' => 'required',
        'coa.tipe' => 'required',
        'coa.posisi' => 'required',
        'coa.header_akun' => 'required'
    ];

    public function mount(){

        if ($this->editmode=='edit') {
            $this->coa = Coa::find($this->coa_id);
        }else{
            $this->coa = new Coa();
        }

    }

    public function save(){

        $this->validate();

        $this->coa->save();

        $this->closeModal();

        $this->alert('success', 'Save Success', [
            'position' => 'center'
        ]);

        $this->emitTo('coa.coa-table', 'pg:eventRefresh-default');

    }

    public function render()
    {
        return view('livewire.coa.coa-modal',[
            'header' => Coa::where('tipe','Header')->get()
        ]);
    }
}
