<?php

namespace App\Http\Livewire\Penjualan;

use App\Models\Barang;
use App\Models\DBarang;
use App\Models\Driver;
use App\Models\DSalesorder;
use App\Models\Journal;
use App\Models\Kartustok;
use App\Models\Kategori;
use App\Models\Kendaraan;
use App\Models\Komposisi;
use App\Models\MSalesorder;
use App\Models\Mutubeton;
use App\Models\Rate;
use App\Models\Satuan;
use App\Models\Ticket;
use App\Models\TicketDetail;
use App\Models\VTicketHeader;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use LivewireUI\Modal\ModalComponent;
use Throwable;

class TicketModal extends ModalComponent
{

    use LivewireAlert;
    public $editmode, $ticket_id;
    public $rate, $kendaraan, $driver ,$satuan, $mutubeton;
    public $m_salesorder_id, $sisa_so, $mutubeton_id;
    public $kendaraan_id, $driver_id, $jumlah, $jam_ticket, $rate_id, $satuan_id, $loading, $tambahan_biaya, $lembur;

    protected $listeners = [
        'selectkendaraan' => 'selectkendaraan',
        'selectdriver' => 'selectdriver',
        'selectrate' => 'selectrate'
    ];

    protected $rules=[
        'kendaraan_id'=> 'required',
        'driver_id'=> 'required',
        'jumlah'=> 'required',
        'jam_ticket'=> 'required',
        'rate_id' => 'required',
        'satuan_id'=> 'required',
        'loading'=> 'required',
        'tambahan_biaya'=> 'required',
        'lembur'=> 'required',
    ];

    public function resetpage()
    {
        $this->kendaraan_id = '';
        $this->driver_id = '';
        $this->jumlah = '';
        $this->jam_ticket = '';
        $this->rate_id = '';
        $this->satuan_id = '';
        $this->loading = '';
        $this->tambahan_biaya = '';
        $this->lembur = '';
    }

    public function mount($m_salesorder_id,$mutubeton_id){

        $user = Auth::user();
        if (!$user->hasPermissionTo('Ticket')){
            return abort(401);
        }

        $this->m_salesorder_id = $m_salesorder_id;
        $this->mutubeton_id = $mutubeton_id;
        $mutubeton = Mutubeton::find($this->mutubeton_id);
        $this->mutubeton = $mutubeton->kode_mutu;
        $satuan = Satuan::find($mutubeton->satuan_id);
        $this->sisa_so = DSalesorder::where('m_salesorder_id', $this->m_salesorder_id)->where('mutubeton_id', $this->mutubeton_id)
                        ->sum('sisa');

        $rate = DSalesorder::where('m_salesorder_id', $this->m_salesorder_id)->where('mutubeton_id', $this->mutubeton_id)->first();
               
        $this->jam_ticket=Date('Y-m-d\TH:i:s');
        $this->satuan_id = $satuan->id;
        $this->rate_id = $rate->rate_id;
        $this->tambahan_biaya = 0;
        $this->lembur = 0;
      
        $datarate = Rate::find($this->rate_id);
        $this->rate = $datarate->tujuan.' - '. number_format($datarate->estimasi_jarak,2,'.',','). ' KM';
        $this->satuan = $satuan->satuan;
    }

    public function selectkendaraan($id){
        
        $this->kendaraan_id=$id;
        $kendaraan = Kendaraan::find($id);
      
        $this->kendaraan = Kendaraan::find($this->kendaraan_id)->nopol;
        $this->loading=$kendaraan->loading;
        $driver = Driver::find($kendaraan->driver_id);
        $this->driver_id = $driver->id;
        $this->driver = Driver::find($this->driver_id)->nama_driver;
        // dd($this->ticket); 
        $this->emitTo('driver.driver-select','selectdata',$driver->id);
    }

    public function selectdriver($id){
        $this->driver_id=$id;
        $this->driver = Driver::find($id)->nama_driver;
    }

    public function selectrate($id){
        $this->rate_id=$id;
        $datarate = Rate::find($id);
        $this->rate = $datarate->tujuan.' - '. number_format($datarate->estimasi_jarak,2,'.',','). ' KM';
    }

    public function save(){

        $this->lembur = str_replace(',', '', $this->lembur);
        $this->jumlah = str_replace(',', '', $this->jumlah);
        $this->tambahan_biaya = str_replace(',', '', $this->tambahan_biaya);
        $this->loading = str_replace(',', '', $this->loading);
        $this->jam_ticket = date_create($this->jam_ticket)->format('Y-m-d H:i:s');
        $this->validate();

        if ($this->jumlah > $this->sisa_so){
            $this->alert('error','Jumlah pengiriman melebihi sisa SO', [
                'position' => 'center'
            ]);
            return;
        }

        $mutubeton = Mutubeton::find($this->mutubeton_id);
        $komposisis = Komposisi::where('mutubeton_id',$this->mutubeton_id)
        ->where('jumlah','>',0)
        ->where('tipe','mengurangi stok')->get();
        
        foreach($komposisis as $komposisi){
            $pemakaianmaterial = (floatval($this->jumlah) / $mutubeton->jumlah) * $komposisi->jumlah;

            $jumlahstok = DBarang::where('barang_id',$komposisi->barang_id)
                            ->sum('jumlah');
            
            if ($jumlahstok < $pemakaianmaterial){
                $barang = Barang::find($komposisi->barang_id);
                $this->alert('error', 'Stok '.$barang->nama_barang.' tidak mencukupi', [
                    'position' => 'center'
                ]);
                $this->addError('stok', 'Stok '.$barang->nama_barang.' tidak mencukupi');
            }
        }

        DB::beginTransaction();

        try{

            DB::update("Exec SP_CreateTicket ".$this->m_salesorder_id.",".
            $this->mutubeton_id.",".
            $this->kendaraan_id.",".
            $this->driver_id.",".
            $this->jumlah.",'".
            $this->jam_ticket."',".
            $this->rate_id.",".
            $this->satuan_id.",".
            $this->loading.",".
            $this->tambahan_biaya.",".
            $this->lembur);

            DB::commit();
            $this->resetpage();
            $this->alert('success', 'Save Success', [
                'position' => 'center'
            ]);
            $this->closeModal();
            $this->emitTo('penjualan.ticket-table', 'pg:eventRefresh-default');
            $this->emitTo('penjualan.salesorder-full-table', 'pg:eventRefresh-default');
        }
        catch(Throwable $e){
            DB::rollBack();
            $this->alert('error', $e->getMessage(), [
                'position' => 'center'
            ]);
            $this->closeModal();
            return;
        }
       
    }

    public static function modalMaxWidth(): string
    {
        return '7xl';
    }

    public function render()
    {
        return view('livewire.penjualan.ticket-modal');
    }
}
