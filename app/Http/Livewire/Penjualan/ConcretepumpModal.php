<?php

namespace App\Http\Livewire\Penjualan;

use App\Models\Concretepump;
use App\Models\Driver;
use App\Models\JarakTempuh;
use App\Models\Kendaraan;
use App\Models\Rate;
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use LivewireUI\Modal\ModalComponent;
use Throwable;

class ConcretepumpModal extends ModalComponent
{
    use LivewireAlert;
    public $m_salesorder_id, $editmode;
    public $kendaraan, $driver, $rate;
    public Concretepump $concretepump;
    public $concretepump_id;

    protected $listeners = [
        'selectkendaraan' => 'selectkendaraan',
        'selectdriver' => 'selectdriver',
        'selectrate' => 'selectrate'
    ];

    protected $rules=[
        'concretepump.kendaraan_id'=> 'required',
        'concretepump.driver_id'=> 'required',
        'concretepump.jarak_tempuh_id'=> 'required',
        'concretepump.rate_id'=> 'required',
        'concretepump.harga_sewa'=> 'required',
        'concretepump.keterangan'=> 'nullable',
    ];

    public function mount($m_salesorder_id)
    {
        $this->m_salesorder_id = $m_salesorder_id;

        if ($this->editmode=='edit') {
            $this->concretepump = Concretepump::find($this->concretepump_id);
            $rate = Rate::find($this->concretepump->rate_id);
            $this->rate = $rate->tujuan.' - '.$rate->estimasi_jarak.' KM';
        }else{
            $this->concretepump = new Concretepump();
        }
       
    }

    public function selectkendaraan($id){
        
        $this->concretepump->kendaraan_id=$id;
        $kendaraan = Kendaraan::find($id);
      
        $this->kendaraan = Kendaraan::find($this->concretepump->kendaraan_id)->nopol;
        $this->concretepump->loading=$kendaraan->loading;
        $driver = Driver::find($kendaraan->driver_id);
        $this->concretepump->driver_id = $driver->id;
        $this->driver = Driver::find($this->concretepump->driver_id)->nama_driver;
        $this->emitTo('driver.driver-select','selectdata',$driver->id);
    }

    public function selectrate($id){
        $this->concretepump->rate_id=$id;
    }

    public function selectdriver($id){
        $this->concretepump->driver_id=$id;
        $this->driver = Driver::find($id)->nama_driver;
    }

    public function save(){

        $this->concretepump->harga_sewa = str_replace('.', '', $this->concretepump->harga_sewa);
        $this->concretepump->harga_sewa = str_replace(',', '.', $this->concretepump->harga_sewa);

        $this->concretepump->m_salesorder_id = $this->m_salesorder_id;

        $this->validate();

        DB::beginTransaction();

        try{

            $this->concretepump->save();
            DB::commit();
        }
        catch(Throwable $e){
            DB::rollBack();
            $this->alert('error', $e->getMessage(), [
                'position' => 'center'
            ]);
            return;
        }
       
        $this->closeModal();

        $this->alert('success', 'Save Success', [
            'position' => 'center'
        ]);

        $this->emitTo('penjualan.rekap-concretepump-table', 'pg:eventRefresh-default');

    }

    public static function modalMaxWidth(): string
    {
        return '7xl';
    }

    public function render()
    {
        return view('livewire.penjualan.concretepump-modal',['jaraktempuh' => JarakTempuh::all()]);
    }
}
