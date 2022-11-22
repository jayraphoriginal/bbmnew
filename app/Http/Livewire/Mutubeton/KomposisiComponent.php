<?php

namespace App\Http\Livewire\Mutubeton;

use App\Models\Mutubeton;
use Illuminate\Support\Facades\Auth;
use LivewireUI\Modal\ModalComponent;

class KomposisiComponent extends ModalComponent
{
    public $mutubeton_id, $kode_mutu, $deskripsi;

    public function mount($mutubeton_id){
        $this->mutubeton_id = $mutubeton_id;
        $mutubeton = Mutubeton::find($mutubeton_id);
        $this->kode_mutu = $mutubeton->kode_mutu;
        $this->deskripsi = $mutubeton->deskripsi;
    }

    public function add(){
        $this->emit("openModal", "mutubeton.komposisi-modal", ["mutubeton_id" => $this->mutubeton_id]);
    }

    public function render()
    {
        $user = Auth::user();
        if (!$user->hasPermissionTo('Komposisi')){
            return abort(401);
        }
        return view('livewire.mutubeton.komposisi-component');
    }

    public static function modalMaxWidth(): string
    {
        return '7xl';
    }
}
