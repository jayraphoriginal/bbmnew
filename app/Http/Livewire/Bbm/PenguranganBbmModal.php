<?php

namespace App\Http\Livewire\Bbm;

use App\Models\PenguranganBbm;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use LivewireUI\Modal\ModalComponent;

class PenguranganBbmModal extends ModalComponent
{
     use LivewireAlert;

    public PenguranganBbm $pengurangan;
    public $editmode, $penambahan_id;
    public $kendaraan, $driver, $bahanbakar;

    protected $listeners = [
        'selectkendaraan' => 'selectkendaraan',
        'selectdriver' => 'selectdriver',
        'selectbahanbakar' => 'selectbahanbakar',
    ];

    protected $rules=[
        'pengurangan.tanggal_pengurangan' => 'required',
        'pengurangan.kendaraan_id' => 'required',
        'pengurangan.driver_id' => 'required',
        'pengurangan.bahan_bakar_id' => 'required',
        'pengurangan.jumlah' => 'required',
        'pengurangan.keterangan' => 'required',
    ];

    public function mount(){

        $user = Auth::user();
        if (!$user->hasPermissionTo('Tambahan BBM')){
            return abort(401);
        }

        if ($this->editmode=='edit') {
            $this->pengurangan = PenguranganBbm::find($this->penambahan_id);
        }else{
            $this->pengurangan = new PenguranganBbm();
        }

    }

    public function selectkendaraan($id){
        $this->pengurangan->kendaraan_id=$id;
    }

    public function selectdriver($id){
        $this->pengurangan->driver_id=$id;
    }

    public function selectbahanbakar($id){
        $this->pengurangan->bahan_bakar_id=$id;
    }

    public function save(){

        $this->pengurangan->jumlah = str_replace(',', '', $this->pengurangan->jumlah);

        $this->validate();

        $this->pengurangan->save();

        $this->closeModal();

        $this->alert('success', 'Save Success', [
            'position' => 'center'
        ]);

        $this->emitTo('bbm.pengurangan-bbm-table', 'pg:eventRefresh-default');

    }

    public function render()
    {
        return view('livewire.bbm.pengurangan-bbm-modal');
    }

}
