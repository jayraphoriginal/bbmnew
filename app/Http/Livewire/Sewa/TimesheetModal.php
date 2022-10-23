<?php

namespace App\Http\Livewire\Sewa;

use App\Models\Concretepump;
use App\Models\Timesheet;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use LivewireUI\Modal\ModalComponent;
use DB;

class TimesheetModal extends ModalComponent
{
    
    use LivewireAlert;

    public Timesheet $timesheet;
    public $editmode, $timesheet_id;
    public $tipe, $d_so_id, $driver;

    protected $listeners = ['selectdriver' => 'selectdriver'];

    protected $rules = [
        'timesheet.d_so_id' => 'required',
        'timesheet.tanggal' => 'required',
        'timesheet.driver_id' => 'required',
        'timesheet.tipe' => 'required',
        'timesheet.jam_awal' => 'nullable',
        'timesheet.jam_akhir' => 'nullable',
        'timesheet.hm_awal' => 'nullable',
        'timesheet.hm_akhir' => 'nullable',
        'timesheet.istirahat' => 'required',
        'timesheet.volume' => 'required',
        'timesheet.keterangan' => 'nullable',
    ];

    public function mount($tipe, $d_so_id){
    
        $this->tipe = $tipe;
        $this->d_so_id = $d_so_id;

        if ($this->editmode=='edit') {
            $this->timesheet = Timesheet::find($this->timesheet_id);
            $this->tipe = $this->timesheet->tipe;
            
        }else{
            $this->timesheet = new Timesheet();
            $this->timesheet->tipe = $this->tipe;
        }
        $this->timesheet->d_so_id = $d_so_id;
    }

    public function selectdriver($id){
        $this->timesheet->driver_id=$id;
    }

    public function save(){

        $this->validate();
        $this->timesheet->jam_awal =date_create($this->timesheet->jam_awal)->format('Y-m-d H:i:s');
        $this->timesheet->jam_akhir =date_create($this->timesheet->jam_akhir)->format('Y-m-d H:i:s');
        $this->timesheet->volume = str_replace(',', '', $this->timesheet->volume);
        $this->timesheet->save();

        $this->closeModal();

        $this->alert('success', 'Save Success', [
            'position' => 'center'
        ]);
    }

    public function render()
    {
        return view('livewire.sewa.timesheet-modal');
    }
}
