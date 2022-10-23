<?php

namespace App\Http\Livewire\Mutubeton;

use App\Models\Mutubeton;
use LivewireUI\Modal\ModalComponent;

class KomposisiComponent extends ModalComponent
{
    public $mutubeton_id, $kode_mutu;

    public function mount($mutubeton_id){
        $this->mutubeton_id = $mutubeton_id;
        $this->kode_mutu = Mutubeton::find($mutubeton_id)->kode_mutu;
    }

    public function add(){
        $this->emit("openModal", "mutubeton.komposisi-modal", ["mutubeton_id" => $this->mutubeton_id]);
    }

    public function render()
    {
        return view('livewire.mutubeton.komposisi-component');
    }

    public static function modalMaxWidth(): string
    {
        return '7xl';
    }
}
