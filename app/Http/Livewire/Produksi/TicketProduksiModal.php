<?php

namespace App\Http\Livewire\Produksi;

use App\Models\Barang;
use App\Models\DBarang;
use App\Models\Driver;
use App\Models\Kendaraan;
use App\Models\Komposisi;
use App\Models\Mutubeton;
use App\Models\Rate;
use App\Models\Satuan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use LivewireUI\Modal\ModalComponent;
use Throwable;

class TicketProduksiModal extends ModalComponent
{
    use LivewireAlert;
    public $editmode, $ticket_id;
    public $kendaraan, $driver ,$satuan, $mutubeton;
    public $mutubeton_id, $loading, $rate, $rate_id;
    public $kendaraan_id, $driver_id, $jumlah, $jam_ticket, $satuan_id;

    protected $listeners = [
        'selectkendaraan' => 'selectkendaraan',
        'selectdriver' => 'selectdriver',
        'selectmutubeton' => 'selectmutubeton',
        'selectrate' => 'selectrate'
    ];

    protected $rules=[
        'kendaraan_id'=> 'required',
        'driver_id'=> 'required',
        'rate_id'=> 'required',
        'jumlah'=> 'required',
        'jam_ticket'=> 'required',
        'satuan_id'=> 'required',
        'loading'=> 'required'
    ];

    public function selectmutubeton($id){
        $this->mutubeton_id=$id;
        $this->satuan_id=Mutubeton::find($id)->satuan_id;
        $this->satuan = Satuan::find($this->satuan_id)->satuan;
    }

    public function resetpage()
    {
        $this->kendaraan_id = '';
        $this->driver_id = '';
        $this->jumlah = '';
        $this->jam_ticket = '';
        $this->satuan_id = '';
        $this->loading = 0;
    }

    public function mount(){

        $user = Auth::user();
        if (!$user->hasPermissionTo('Ticket Produksi')){
            return abort(401);
        }
        $this->jam_ticket=Date('Y-m-d\TH:i:s');
    }

    public function selectrate($id){
        $this->rate_id=$id;
        $datarate = Rate::find($id);
        $this->rate = $datarate->tujuan.' - '. number_format($datarate->estimasi_jarak,2,'.',','). ' KM';
    }

    public function selectkendaraan($id){
        
        $this->kendaraan_id=$id;
        $kendaraan = Kendaraan::find($id);
      
        $this->kendaraan = Kendaraan::find($this->kendaraan_id)->nopol;
        $this->loading = Kendaraan::find($this->kendaraan_id)->loading;
        $driver = Driver::find($kendaraan->driver_id);
        $this->driver_id = $driver->id;
        $this->driver = Driver::find($this->driver_id)->nama_driver;
        $this->emitTo('driver.driver-select','selectdata',$driver->id);
    }

    public function selectdriver($id){
        $this->driver_id=$id;
        $this->driver = Driver::find($id)->nama_driver;
    }

    public function save(){

        $this->jumlah = str_replace(',', '', $this->jumlah);
        $this->jam_ticket = date_create($this->jam_ticket)->format('Y-m-d H:i:s');
        $this->loading = str_replace(',', '', $this->loading);
        $this->validate();

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
                return;
            }
        }

        DB::beginTransaction();

        try{

            DB::statement("SET NOCOUNT ON; Exec SP_CreateTicketProduksi ".
            $this->mutubeton_id.",".
            $this->kendaraan_id.",".
            $this->driver_id.",".
            $this->rate_id.",".
            $this->jumlah.",'".
            $this->jam_ticket."',".
            $this->satuan_id.",".
            $this->loading);

            DB::commit();
            $this->resetpage();
            $this->alert('success', 'Save Success', [
                'position' => 'center'
            ]);
            $this->closeModal();
            $this->emitTo('produksi.ticket-produksi-table', 'pg:eventRefresh-default');
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
        return view('livewire.produksi.ticket-produksi-modal');
    }
}
