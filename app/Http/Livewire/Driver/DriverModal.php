<?php

namespace App\Http\Livewire\Driver;

use App\Models\Driver;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use LivewireUI\Modal\ModalComponent;

class DriverModal extends ModalComponent
{
    public function render()
    {
        return view('livewire.driver.driver-modal');
    }
    use LivewireAlert;

    public Driver $driver;
    public $editmode, $driver_id;


    protected $rules=[
        'driver.nama_driver' => 'required',
        'driver.tmpt_lahir' => 'required',
        'driver.tgl_lahir' => 'required',
        'driver.alamat' => 'required',
        'driver.pendidikan_terakhir' => 'required',
        'driver.tgl_masuk' => 'required',
        'driver.agama' => 'required',
        'driver.status' => 'required',
        'driver.gol_darah' => 'required',
        'driver.nobpjstk' => 'required',
        'driver.nobpjskes' => 'required',
        'driver.notelp' => 'required',
        'driver.status_kerja' => 'required'
    ];

    public function mount(){

        if ($this->editmode=='edit') {
            $this->driver = Driver::find($this->driver_id);
        }else{
            $this->driver = new Driver();
        }

    }

    public function save(){

        $this->validate();

        $this->driver->save();

        $this->closeModal();

        $this->alert('success', 'Save Success', [
            'position' => 'center'
        ]);

        $this->emitTo('driver.driver-table', 'pg:eventRefresh-default');

    }

}
