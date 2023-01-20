<?php

namespace App\Http\Livewire\Penjualan;

use App\Models\Driver;
use App\Models\Kendaraan;
use App\Models\Rate;
use App\Models\Ticket;
use App\Models\VTicketHeader;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use LivewireUI\Modal\ModalComponent;

class TicketEditModal extends ModalComponent
{
    use LivewireAlert;

    public Ticket $ticket;
    public $editmode, $ticket_id;
    public $rate, $kendaraan, $driver ,$satuan, $mutubeton;
    public $m_salesorder_id, $sisa_so, $mutubeton_id, $nourutawal;

    protected $listeners = [
        'selectkendaraan' => 'selectkendaraan',
        'selectdriver' => 'selectdriver',
        'selectrate' => 'selectrate'
    ];

    protected $rules=[
        'ticket.kendaraan_id'=> 'required',
        'ticket.driver_id'=> 'required',
        'ticket.jumlah'=> 'required',
        'ticket.jam_ticket'=> 'nullable',
        'ticket.rate_id' => 'required',
        'ticket.satuan_id'=> 'required',
        'ticket.loading'=> 'required',
        'ticket.tambahan_biaya'=> 'required',
        'ticket.lembur'=> 'required',
        'ticket.nourut' => 'nullable'
    ];

    public function selectkendaraan($id){
        
        $this->ticket->kendaraan_id=$id;
        $kendaraan = Kendaraan::find($id);
      
        $this->kendaraan = Kendaraan::find($this->ticket->kendaraan_id)->nopol;
        $this->ticket->loading=$kendaraan->loading;
        $driver = Driver::find($kendaraan->driver_id);
        $this->ticket->driver_id = $driver->id;
        $this->driver = Driver::find($this->ticket->driver_id)->nama_driver;
        // dd($this->ticket); 
        $this->emitTo('driver.driver-select','selectdata',$driver->id);
        
    }

    public function selectdriver($id){
        $this->ticket->driver_id=$id;
        $this->driver = Driver::find($id)->nama_driver;
    }

    public function selectrate($id){
        $this->ticket->rate_id=$id;
        $datarate = Rate::find($id);
        $this->rate = $datarate->tujuan.' - '. number_format($datarate->estimasi_jarak,2,'.',','). ' KM';
    }

    public function mount(){

        $user = Auth::user();
        if (!$user->hasPermissionTo('Edit Ticket')){
            return abort(401);
        }

        $this->ticket = Ticket::find($this->ticket_id);
        $dataticket = VTicketHeader::find($this->ticket_id);
        $this->mutubeton = $dataticket->kode_mutu;
        $this->kendaraan = $dataticket->nopol;
        $this->driver = $dataticket->nama_driver; 
        $this->satuan = $dataticket->satuan;
        $this->rate = $dataticket->tujuan.' - '. number_format($dataticket->estimasi_jarak,2,'.',','). ' KM';
        $this->ticket->jam_ticket = date_create($this->ticket->jam_ticket)->format("Y-m-d\TH:i:s");
        $this->nourutawal = $this->ticket->nourut;
    }

    public function save(){
        $this->ticket->lembur = str_replace(',', '', $this->ticket->lembur);
        $this->ticket->jumlah = str_replace(',', '', $this->ticket->jumlah);
        $this->ticket->tambahan_biaya = str_replace(',', '', $this->ticket->tambahan_biaya);

        $this->ticket->jam_ticket = date_create($this->ticket->jam_ticket)->format('Y-m-d H:i:s');

        $dataticketso = VTicketHeader::find($this->ticket->id);
        $nomorticket = VTicketHeader::where('so_id',$dataticketso->so_id)->where('nourut',$this->ticket->nourut)->get();

        if ((count($nomorticket)>0) && ($this->nourutawal <> $this->ticket->nourut)){
            $this->alert('error', 'nomor urut ticket sudah ada', [
                'position' => 'center'
            ]);
        }else{

            $this->validate();
            $this->ticket->save();

            $this->closeModal();

            $this->alert('success', 'Save Success', [
                'position' => 'center'
            ]);

            $this->emitTo('penjualan.ticket-table', 'pg:eventRefresh-default');
            $this->emitTo('penjualan.salesorder-full-table', 'pg:eventRefresh-default');
        }
    }


    public function render()
    {
        return view('livewire.penjualan.ticket-edit-modal');
    }
}
