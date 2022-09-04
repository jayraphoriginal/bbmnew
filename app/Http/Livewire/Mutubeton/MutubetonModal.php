<?php

namespace App\Http\Livewire\Mutubeton;

use App\Models\Satuan;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use App\Models\Mutubeton;
use LivewireUI\Modal\ModalComponent;

class MutubetonModal extends ModalComponent
{
    use LivewireAlert;

    public function render()
    {
        return view('livewire.mutubeton.mutubeton-modal');
    }

    public Mutubeton $mutubeton;
    public $editmode, $mutubeton_id;
    public $satuan;

    protected $listeners = ['selectsatuan' => 'selectsatuan'];

    protected $rules=[
        'mutubeton.kode_mutu' => 'required',
        'mutubeton.jumlah' => 'required',
        'mutubeton.satuan_id' => 'required',
        'mutubeton.berat_jenis' => 'required',
    ];

    public function mount(){

        if ($this->editmode=='edit') {
            $this->mutubeton = Mutubeton::find($this->mutubeton_id);
            $this->satuan = Satuan::find($this->mutubeton->satuan_id)->satuan;
        }else{
            $this->mutubeton = new Mutubeton();
        }

    }

    public function selectsatuan($id){
        $this->mutubeton->satuan_id=$id;
    }

    public function save(){

        $this->validate();

        $this->mutubeton->jumlah = str_replace(',', '', $this->mutubeton->jumlah);

        $this->mutubeton->berat_jenis = str_replace(',', '', $this->mutubeton->berat_jenis);

        $this->mutubeton->save();

        $this->closeModal();

        $this->alert('success', 'Save Success', [
            'position' => 'center'
        ]);

        $this->emitTo('mutubeton.mutubeton-table', 'pg:eventRefresh-default');

    }
}
