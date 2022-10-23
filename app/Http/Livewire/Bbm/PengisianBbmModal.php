<?php

namespace App\Http\Livewire\Bbm;

use App\Models\PengisianBbm;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use LivewireUI\Modal\ModalComponent;

class PengisianBbmModal extends ModalComponent
{
    use LivewireAlert;

    public PengisianBbm $pengisian;
    public $editmode, $pengisian_id;
    public $supplier, $kendaraan, $driver, $bahanbakar;

    protected $listeners = [
        'selectsupplier' => 'selectsupplier',
        'selectkendaraan' => 'selectkendaraan',
        'selectdriver' => 'selectdriver',
        'selectbahanbakar' => 'selectbahanbakar',
    ];

    protected $rules=[
        'pengisian.tanggal_pengisian' => 'required',
        'pengisian.supplier_id' => 'required',
        'pengisian.kendaraan_id' => 'required',
        'pengisian.driver_id' => 'required',
        'pengisian.bahan_bakar_id' => 'required',
        'pengisian.jumlah' => 'required',
        'pengisian.harga' => 'required'
    ];

    public function mount(){

        if ($this->editmode=='edit') {
            $this->pengisian = PengisianBbm::find($this->pengisian_id);
        }else{
            $this->pengisian = new PengisianBbm();
        }

    }

    public function selectsupplier($id){
        $this->pengisian->supplier_id=$id;
    }

    public function selectkendaraan($id){
        $this->pengisian->kendaraan_id=$id;
    }

    public function selectdriver($id){
        $this->pengisian->driver_id=$id;
    }

    public function selectbahanbakar($id){
        $this->pengisian->bahan_bakar_id=$id;
    }

    public function save(){

        $this->pengisian->harga = str_replace(',', '', $this->pengisian->harga);

        $this->pengisian->jumlah = str_replace(',', '', $this->pengisian->jumlah);

        $this->validate();

        $this->pengisian->save();

        $this->closeModal();

        $this->alert('success', 'Save Success', [
            'position' => 'center'
        ]);

        $this->emitTo('bbm.pengisian-bbm-table', 'pg:eventRefresh-default');

    }

    public function render()
    {
        return view('livewire.bbm.pengisian-bbm-modal');
    }
}
