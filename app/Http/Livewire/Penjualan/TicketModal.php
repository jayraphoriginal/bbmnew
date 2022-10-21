<?php

namespace App\Http\Livewire\Penjualan;

use App\Models\Barang;
use App\Models\Coa;
use App\Models\Customer;
use App\Models\DBarang;
use App\Models\Driver;
use App\Models\DSalesorder;
use App\Models\Journal;
use App\Models\Kartustok;
use App\Models\Kategori;
use App\Models\Kendaraan;
use App\Models\Komposisi;
use App\Models\Mpajak;
use App\Models\MSalesorder;
use App\Models\Mutubeton;
use App\Models\Rate;
use App\Models\Satuan;
use App\Models\Ticket;
use App\Models\TicketDetail;
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
    public $m_salesorder_id, $sisa_so, $mutubeton_id;

    protected $listeners = [
        'selectkendaraan' => 'selectkendaraan',
        'selectdriver' => 'selectdriver'
    ];

    protected $rules=[
        'ticket.kendaraan_id'=> 'required',
        'ticket.driver_id'=> 'required',
        'ticket.jumlah'=> 'required',
        'ticket.jam_ticket'=> 'nullable',
        'ticket.rate_id' => 'nullable',
        'ticket.satuan_id'=> 'required',
        'ticket.loading'=> 'required',
        'ticket.tambahan_biaya'=> 'required',
        'ticket.lembur'=> 'required',
    ];

    public function mount($m_salesorder_id,$mutubeton_id){
        $this->m_salesorder_id = $m_salesorder_id;
        $this->mutubeton_id = $mutubeton_id;
        $mutubeton = Mutubeton::find($this->mutubeton_id);
        $this->mutubeton = $mutubeton->kode_mutu;
        $satuan = Satuan::find($mutubeton->satuan_id);
        $this->sisa_so = DSalesorder::where('m_salesorder_id', $this->m_salesorder_id)->where('mutubeton_id', $this->mutubeton_id)
                        ->sum('sisa');

        $rate = DSalesorder::where('m_salesorder_id', $this->m_salesorder_id)->where('mutubeton_id', $this->mutubeton_id)->first();
               
        $this->ticket = new Ticket();
        $this->ticket->jam_ticket=date('Y-m-d H:i');
        $this->ticket->satuan_id = $satuan->id;
        $this->ticket->rate_id = $rate->rate_id;
        $this->ticket->tambahan_biaya = 0;
        $this->ticket->lembur = 0;
      
        $datarate = Rate::find($this->ticket->rate_id);
        $this->rate = $datarate->tujuan.' - '. number_format($datarate->estimasi_jarak,2,'.',','). ' KM';
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

    public function selectrate($id){
        $this->ticket->rate_id=$id;
        $datarate = Rate::find($id);
        $this->rate = $datarate->tujuan.' - '. number_format($datarate->estimasi_jarak,2,'.',','). ' KM';
    }

    public function save(){

        $this->ticket->lembur = str_replace(',', '', $this->ticket->lembur);

        $this->ticket->jumlah = str_replace(',', '', $this->ticket->jumlah);

        $this->ticket->tambahan_biaya = str_replace(',', '', $this->ticket->tambahan_biaya);

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
            $this->ticket->status = 'Open';
            $this->ticket->jam_ticket = date_create($this->ticket->jam_ticket)->format('Y-m-d H:i:s');
            $this->ticket->save();

            

            $d_salesorders = DSalesorder::where('m_salesorder_id',$this->m_salesorder_id)
            ->where('mutubeton_id',$this->mutubeton_id)->get();

            $jumlah = $this->ticket->jumlah;
            foreach($d_salesorders as $d_salesorder){
                if ($jumlah>0){
                    if($jumlah>$d_salesorder->sisa){
                        $jumlah = $jumlah-$d_salesorder['sisa'];

                        $dticket = new TicketDetail();
                        $dticket['ticket_id']=$this->ticket->id;
                        $dticket['d_salesorder_id']=$d_salesorder->id;
                        $dticket['jumlah']=$d_salesorder['sisa'];
                        $dticket->save();

                        $datad_salesorder = DSalesorder::find($d_salesorder->id);
                        $datad_salesorder['sisa']=0;
                        $datad_salesorder->save();

                    }else{
                        $jumlah=0;

                        $dticket = new TicketDetail();
                        $dticket['ticket_id']=$this->ticket->id;
                        $dticket['d_salesorder_id']=$d_salesorder->id;
                        $dticket['jumlah']=$jumlah;
                        $dticket->save();

                        $datad_salesorder = DSalesorder::find($d_salesorder->id);
                        $datad_salesorder['sisa']=$datad_salesorder['sisa']-$jumlah;
                        $datad_salesorder->save();

                    }
                }
            }
            

            $mutubeton = Mutubeton::find($this->mutubeton_id);
            $komposisis = Komposisi::where('mutubeton_id',$this->mutubeton_id)->where('jumlah','>',0)->get();
            
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

                    foreach($detailbarang as $dbarang){

                        if ($pemakaianmaterial > 0){
                            if($pemakaianmaterial > $dbarang->jumlah){
                                
                                $stok = DBarang::find($dbarang->id);  
                                $pengurangan = $stok->jumlah;
                                $stok['jumlah']=0;
                                $stok->save();

                                $jumlahstok = DBarang::where('barang_id',$komposisi->barang_id)
                                    ->sum('jumlah');

                                $kartustok = new Kartustok();
                                $kartustok['barang_id']=$komposisi->barang_id;
                                $kartustok['tanggal'] = date_create($this->ticket->jam_ticket)->format('Y-m-d');
                                $kartustok['tipe']='Ticket';
                                $kartustok['trans_id']=$this->ticket->id;
                                $kartustok['increase']=0;
                                $kartustok['decrease']=$pengurangan;
                                $kartustok['harga_debet']=0;
                                $kartustok['harga_kredit']=$stok->hpp;
                                $kartustok['qty']=$jumlahstok;
                                $kartustok['modal']=$stok->hpp;
                                $kartustok->save();

                                $databarang = Barang::find($komposisi->barang_id);
                                $kategori = Kategori::find($databarang->kategori_id);

                                $journal = new Journal();
                                $journal['tipe']='Ticket';
                                $journal['trans_id']=$this->ticket->id;
                                $journal['tanggal_transaksi']=date_create($this->ticket->jam_ticket)->format('Y-m-d');
                                $journal['coa_id']=$kategori->coa_hpp_id;
                                $journal['debet']=round($stok->hpp*$pengurangan,4);
                                $journal['kredit']=0;
                                $journal->save();

                                $journal = new Journal();
                                $journal['tipe']='Ticket';
                                $journal['trans_id']=$this->ticket->id;
                                $journal['tanggal_transaksi']=date_create($this->ticket->jam_ticket)->format('Y-m-d');
                                $journal['coa_id']=$kategori->coa_asset_id;
                                $journal['debet']=0;
                                $journal['kredit']=round($stok->hpp*$pengurangan,4);
                                $journal->save();

                                $pemakaianmaterial = $pemakaianmaterial - $pengurangan;
                            }else{

                                $stok = DBarang::find($dbarang->id);
                                $stok['jumlah']=$stok['jumlah']-$pemakaianmaterial;
                                $stok->save();

                                $jumlahstok = DBarang::where('barang_id',$komposisi->barang_id)
                                    ->sum('jumlah');

                                $kartustok = new Kartustok();
                                $kartustok['tanggal'] = date_create($this->ticket->jam_ticket)->format('Y-m-d');
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

                                $databarang = Barang::find($komposisi->barang_id);
                                $kategori = Kategori::find($databarang->kategori_id);

                                $journal = new Journal();
                                $journal['tipe']='Ticket';
                                $journal['trans_id']=$this->ticket->id;
                                $journal['tanggal_transaksi']=date_create($this->ticket->jam_ticket)->format('Y-m-d');
                                $journal['coa_id']=$kategori->coa_hpp_id;
                                $journal['debet']=round($stok->hpp*$pemakaianmaterial,4);
                                $journal['kredit']=0;
                                $journal->save();

                                $journal = new Journal();
                                $journal['tipe']='Ticket';
                                $journal['trans_id']=$this->ticket->id;
                                $journal['tanggal_transaksi']=date_create($this->ticket->jam_ticket)->format('Y-m-d');
                                $journal['coa_id']=$kategori->coa_asset_id;
                                $journal['debet']=0;
                                $journal['kredit']=round($stok->hpp*$pemakaianmaterial,4);
                                $journal->save();

                                $pemakaianmaterial = 0;
                            }
                        }
                    }
                }
            }

            DB::table('d_salesorders')->where('sisa','<=',0)->update([
                'status_detail' => 'Finish'
            ]);

            //$dsaledorder = DSalesorder::find($this->ticket->d_salesorder_id);
            $msalesorder = MSalesorder::find($this->m_salesorder_id);
            
            $pajak = Mpajak::where('jenis_pajak','PPN')->first();
            $customer = Customer::find($msalesorder->customer_id);

            $totalpenjualan = $d_salesorder->harga_intax * $this->ticket->jumlah;
            $dpp = round($totalpenjualan / (1 + ($pajak->persen / 100)),4);
            $ppn = round($totalpenjualan - $dpp,4);

            //Jurnal Piutang
            $journal = new Journal();
            $journal['tipe']='Ticket';
            $journal['trans_id']=$this->ticket->id;
            $journal['tanggal_transaksi']=date_create($this->ticket->jam_ticket)->format('Y-m-d');
            $journal['coa_id']=$customer->coa_id;
            $journal['debet']=$totalpenjualan;
            $journal['kredit']=0;
            $journal->save();

            //Jurnal PPN Keluaran
            $journal = new Journal();
            $journal['tipe']='Ticket';
            $journal['trans_id']=$this->ticket->id;
            $journal['tanggal_transaksi']=date_create($this->ticket->jam_ticket)->format('Y-m-d');
            $journal['coa_id']=$pajak->coa_id_kredit;
            $journal['debet']=0;
            $journal['kredit']=$ppn;
            $journal->save();

            $coapenjualan = Coa::where('kode_akun','400001')->first();
            // Jurnal penjualan
            $journal = new Journal();
            $journal['tipe']='Ticket';
            $journal['trans_id']=$this->ticket->id;
            $journal['tanggal_transaksi']=date_create($this->ticket->jam_ticket)->format('Y-m-d');
            $journal['coa_id']=$coapenjualan->id;
            $journal['debet']=0;
            $journal['kredit']=$dpp;
            $journal->save();

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
