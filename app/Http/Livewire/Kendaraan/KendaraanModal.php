<?php

namespace App\Http\Livewire\Kendaraan;

use App\Models\Kendaraan;
use App\Models\Driver;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use LivewireUI\Modal\ModalComponent;

class KendaraanModal extends ModalComponent
{
    use LivewireAlert;

    public Kendaraan $kendaraan;
    public $editmode, $kendaraan_id;
    public $driver;

    protected $listeners = ['selectdriver' => 'selectdriver'];

    protected $rules=[
        'kendaraan.nopol' => 'required',
        'kendaraan.nama_pemilik' => 'required',
        'kendaraan.alamat' => 'required',
        'kendaraan.tipe' => 'required',
        'kendaraan.model' => 'required',
        'kendaraan.tahun_pembuatan' => 'required',
        'kendaraan.warnakb' => 'required',
        'kendaraan.berlaku_sampai' => 'required',
        'kendaraan.berlaku_kir' => 'required',
        'kendaraan.tgl_perolehan' => 'required',
        'kendaraan.siu' => 'required',
        'kendaraan.muatan' => 'required',
        'kendaraan.loading' => 'required',
        'kendaraan.driver_id' => 'required'
    ];

    public function mount(){

        if ($this->editmode=='edit') {
            $this->kendaraan = Kendaraan::find($this->kendaraan_id);
            $this->driver = Driver::find($this->kendaraan->driver_id)->nama_driver;
        }else{
            $this->kendaraan = new Kendaraan();
        }

    }

    public function selectdriver($id){
        $this->kendaraan->driver_id=$id;
    }

    public function save(){

        $this->validate();

        $this->kendaraan->loading = str_replace(',', '', $this->kendaraan->loading);

        $this->kendaraan->muatan = str_replace(',', '', $this->kendaraan->muatan);

        $this->kendaraan->save();

        $this->closeModal();

        $this->alert('success', 'Save Success', [
            'position' => 'center'
        ]);

        $this->emitTo('kendaraan.kendaraan-table', 'pg:eventRefresh-default');

    }

    public function render()
    {
        return view('livewire.kendaraan.kendaraan-modal');
    }
}
