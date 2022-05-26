<?php

namespace App\Http\Livewire\Penjualan;

use App\Models\Barang;
use App\Models\DBarang;
use App\Models\Driver;
use App\Models\DSalesorder;
use App\Models\Kartustok;
use App\Models\Kendaraan;
use App\Models\Komposisi;
use App\Models\Mutubeton;
use App\Models\Rate;
use App\Models\Satuan;
use App\Models\Ticket;
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use LivewireUI\Modal\ModalComponent;
use Throwable;

class TicketModal extends ModalComponent
{

    use LivewireAlert;
    public Ticket $ticket;
    public $editmode, $ticket_id;
    public $rate, $kendaraan, $driver ,$satuan, $mutubeton;
    public $d_salesorder_id, $sisa_so, $mutubeton_id;

    protected $listeners = [
        'selectkendaraan' => 'selectkendaraan',
        'selectdriver' => 'selectdriver'
    ];

    protected $rules=[
        'ticket.kendaraan_id'=> 'required',
        'ticket.driver_id'=> 'required',
        'ticket.jumlah'=> 'required',
        'ticket.jam_ticket'=> 'nullable',
        
        'ticket.satuan_id'=> 'required',
        'ticket.loading'=> 'required',
        'ticket.tambahan_biaya'=> 'required',
        'ticket.lembur'=> 'required',
    ];

    public function mount($d_salesorder_id){
        $this->d_salesorder_id = $d_salesorder_id;
        $d_salesorder = DSalesorder::find($this->d_salesorder_id);
        $this->sisa_so = $d_salesorder->sisa;
        $mutubeton = Mutubeton::find($d_salesorder->mutubeton_id);
        $this->mutubeton_id = $mutubeton->id;
        $this->mutubeton = $mutubeton->kode_mutu;
        $satuan = Satuan::find($d_salesorder->satuan_id);

        if ($this->editmode=='edit') {
            $this->ticket = Ticket::find($this->ticket_id);
            $kendaraan = Kendaraan::find($this->ticket->kendaraan_id);
            $this->kendaraan = Kendaraan::find($this->ticket->kendaraan_id)->nopol;
            $this->ticket->loading=$kendaraan->loading;
            $driver = Driver::find($this->ticket->driver_id);
            $this->ticket->driver_id = $driver->id;
            $this->driver = Driver::find($this->ticket->driver_id)->nama_driver;
        }else{
            $this->ticket = new Ticket();
            $this->ticket->jam_ticket=date('Y-m-d\TH:i');
            $this->ticket->satuan_id = $satuan->id;
            
        }
        $this->satuan = $satuan->satuan;
    }

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

    public function save(){

        $this->ticket->lembur = str_replace('.', '', $this->ticket->lembur);
        $this->ticket->lembur = str_replace(',', '.', $this->ticket->lembur);

        $this->ticket->jumlah = str_replace('.', '', $this->ticket->jumlah);
        $this->ticket->jumlah = str_replace(',', '.', $this->ticket->jumlah);

        $this->ticket->tambahan_biaya = str_replace('.', '', $this->ticket->tambahan_biaya);
        $this->ticket->tambahan_biaya = str_replace(',', '.', $this->ticket->tambahan_biaya);

        // $this->ticket->loading = str_replace('.', '', $this->ticket->loading);
        // $this->ticket->loading = str_replace(',', '.', $this->ticket->loading);

        $this->ticket->d_salesorder_id = $this->d_salesorder_id;

        $this->validate();

        if ($this->ticket->jumlah > $this->sisa_so){
            $this->alert('error','Jumlah pengiriman melebihi sisa SO', [
                'position' => 'center'
            ]);
            return;
        }


        DB::beginTransaction();

        try{

            if ($this->editmode!='edit') {

                $nomorterakhir = DB::table('tickets')->orderBy('id', 'DESC')->get();

                if (count($nomorterakhir) == 0){
                    $noticket = '0001/DO/'.date('m').'/'.date('Y');               
                }else{
                    if (
                        substr($nomorterakhir[0]->noticket, 8, 2) == date('m')
                        &&
                        substr($nomorterakhir[0]->noticket, 11, 4) == date('Y')
                    ) {
                        $noakhir = intval(substr($nomorterakhir[0]->noticket, 0, 4)) + 1;
                        $noticket = substr('0000' . $noakhir, -4) . '/DO/' . date('m') . '/' . date('Y');
                    } else {
                        $noticket = '0001/DO/' . date('m') . '/' . date('Y');
                    }
                }
            }

            $this->ticket->noticket = $noticket;

            $this->ticket->save();

            $d_salesorder = DSalesorder::find($this->d_salesorder_id);
            $d_salesorder['sisa'] = $d_salesorder['sisa'] - $this->ticket->jumlah;
            $d_salesorder->save();

            $mutubeton = Mutubeton::find($this->mutubeton_id);
            $komposisis = Komposisi::where('mutubeton_id',$this->mutubeton_id)->get();
            
            foreach($komposisis as $komposisi){

                $pemakaianmaterial = (floatval($this->ticket->jumlah) / $mutubeton->jumlah) * $komposisi->jumlah;

                $jumlahstok = DBarang::where('barang_id',$komposisi->barang_id)
                                ->sum('jumlah');
                
                if ($jumlahstok < $pemakaianmaterial){
                    $barang = Barang::find($komposisi->barang_id);
                    DB::Rollback();
                    $this->alert('error', 'Stok '.$barang->nama_barang.' tidak mencukupi', [
                        'position' => 'center'
                    ]);
                    return;
                }else{
                    $detailbarang = DBarang::where('barang_id',$komposisi->barang_id)
                                    ->where('jumlah', '>',0)
                                    ->orderBy('tgl_masuk','asc')
                                    ->get();

                    foreach($detailbarang as $barang){

                        if ($pemakaianmaterial > 0){
                            if($pemakaianmaterial > $barang->jumlah){
                                
                                $stok = DBarang::find($barang->id);
                                $pemakaianmaterial = $pemakaianmaterial - $stok->jumlah;
                                $pengurangan = $stok->jumlah;
                                $stok['jumlah']=0;
                                $stok->save();

                                $jumlahstok = DBarang::where('barang_id',$komposisi->barang_id)
                                    ->sum('jumlah');

                                $kartustok = new Kartustok();
                                $kartustok['barang_id']=$komposisi->barang_id;
                                $kartustok['tipe']='Ticket';
                                $kartustok['trans_id']=$this->ticket->id;
                                $kartustok['increase']=0;
                                $kartustok['decrease']=$pengurangan;
                                $kartustok['harga_debet']=0;
                                $kartustok['harga_kredit']=$stok->hpp;
                                $kartustok['qty']=$jumlahstok;
                                $kartustok['modal']=$stok->hpp;
                                $kartustok->save();

                            }else{

                                $stok = DBarang::find($barang->id);
                                $stok['jumlah']=$stok['jumlah']-$pemakaianmaterial;
                                $stok->save();

                                $jumlahstok = DBarang::where('barang_id',$komposisi->barang_id)
                                    ->sum('jumlah');

                                $kartustok = new Kartustok();
                                $kartustok['barang_id']=$komposisi->barang_id;
                                $kartustok['tipe']='Ticket';
                                $kartustok['trans_id']=$this->ticket->id;
                                $kartustok['increase']=0;
                                $kartustok['decrease']=$pemakaianmaterial;
                                $kartustok['harga_debet']=0;
                                $kartustok['harga_kredit']=$stok->hpp;
                                $kartustok['qty']=$jumlahstok;
                                $kartustok['modal']=$stok->hpp;
                                $kartustok->save();

                                $pemakaianmaterial = 0;

                            }
                        }
                    }
                }                
            }

            DB::table('d_salesorders')->where('sisa','<=',0)->update([
                'status_detail' => 'Finish'
            ]);

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

        $this->emitTo('penjualan.ticket-table', 'pg:eventRefresh-default');
        $this->emitTo('penjualan.salesorder-full-table', 'pg:eventRefresh-default');

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
