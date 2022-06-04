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
        
        if($this->timesheet->tipe =='include mixer'){

            $concretepumps = Concretepump::find($this->timesheet->d_so_id);
            
            $this->timesheet->keterangan = DB::table('d_salesorders')
            ->where('d_salesorders.m_salesorder_id',$concretepumps->m_salesorder_id)
            ->sum('jumlah');
            
        }

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
