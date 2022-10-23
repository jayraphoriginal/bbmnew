<?php

namespace App\Http\Livewire\Bbm;

use App\Models\TambahanBbm;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use LivewireUI\Modal\ModalComponent;

class PenambahanBbmModal extends ModalComponent
{
    use LivewireAlert;

    public TambahanBbm $penambahan;
    public $editmode, $penambahan_id;
    public $kendaraan, $driver, $bahanbakar;

    protected $listeners = [
        'selectkendaraan' => 'selectkendaraan',
        'selectdriver' => 'selectdriver',
        'selectbahanbakar' => 'selectbahanbakar',
    ];

    protected $rules=[
        'penambahan.tanggal_penambahan' => 'required',
        'penambahan.kendaraan_id' => 'required',
        'penambahan.driver_id' => 'required',
        'penambahan.bahan_bakar_id' => 'required',
        'penambahan.jumlah' => 'required',
        'penambahan.keterangan' => 'required',
    ];

    public function mount(){

        if ($this->editmode=='edit') {
            $this->penambahan = TambahanBbm::find($this->penambahan_id);
        }else{
            $this->penambahan = new TambahanBbm();
        }

    }

    public function selectkendaraan($id){
        $this->penambahan->kendaraan_id=$id;
    }

    public function selectdriver($id){
        $this->penambahan->driver_id=$id;
    }

    public function selectbahanbakar($id){
        $this->penambahan->bahan_bakar_id=$id;
    }

    public function save(){

        $this->penambahan->jumlah = str_replace(',', '', $this->penambahan->jumlah);

        $this->validate();

        $this->penambahan->save();

        $this->closeModal();

        $this->alert('success', 'Save Success', [
            'position' => 'center'
        ]);

        $this->emitTo('bbm.penambahan-bbm-table', 'pg:eventRefresh-default');

    }

    public function render()
    {
        return view('livewire.bbm.penambahan-bbm-modal');
    }
}
