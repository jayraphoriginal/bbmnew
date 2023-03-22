<?php

namespace App\Http\Livewire\Invoice;

use App\Models\Concretepump;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\MPenjualan;
use App\Models\MSalesorder;
use App\Models\MSalesorderSewa;
use App\Models\PenjualanRetail;
use App\Models\Timesheet;
use App\Models\VPenjualan;
use App\Models\VSalesOrder;
use App\Models\VSalesOrderSewa;
use App\Models\VTicketHeader;
use App\Models\VTimesheetConcretepump;
use App\Models\VTimesheetSewa;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use LivewireUI\Modal\ModalComponent;
use Throwable;

class InvoiceModal extends ModalComponent
{

    use LivewireAlert;

    public $noso, $so_id, $tipe_so, $customer;
    public Invoice $invoice;    
    public $pembayaran;
    public $tgl_awal, $tgl_akhir, $jumlah_total, $dp, $jumlah_dp, $jumlah_penjualan_retail;
    public $rekening, $dp_sebelum, $pajak, $customer_id, $rekening_id, $tgl_cetak, $tanda_tangan, $keterangan;

    protected $listeners = ['selectrekening' => 'selectrekening'];

    protected $rules =[
        'rekening_id' => 'required',
        'tgl_cetak' => 'required',
        'tanda_tangan' => 'required',
        'keterangan' => 'nullable'
    ];

    public function selectrekening($id){
        $this->rekening_id=$id;
    }

    public function mount(){

        $user = Auth::user();
        if (!$user->hasPermissionTo('Invoice')){
            return abort(401);
        }

        $this->tgl_cetak = date('Y-m-d');
        if ($this->tipe_so=='Ready Mix'){
            $msalesorder = MSalesorder::find($this->so_id);
            $this->pembayaran = $msalesorder->pembayaran;
            $this->customer_id = $msalesorder->customer_id;
            $this->noso = $msalesorder->noso;
            $this->pajak = $msalesorder->pajak;
            $customers = Customer::find($msalesorder->customer_id);
            $this->customer = $customers->nama_customer;
        }
        elseif($this->tipe_so=='Penjualan'){
            $penjualan = MPenjualan::find($this->so_id);
            $this->pembayaran = $penjualan->pembayaran;
            $this->customer_id = $penjualan->customer_id;
            $this->noso = $penjualan->nopenjualan;
            $this->pajak = $penjualan->pajak;
            $customers = Customer::find($penjualan->customer_id);
            $this->customer = $customers->nama_customer;
        }else{
            $msalesorder = MSalesorderSewa::find($this->so_id);
            $this->customer_id = $msalesorder->customer_id;
            $this->pembayaran = $msalesorder->pembayaran;
            $this->noso = $msalesorder->noso;
            $this->pajak = $msalesorder->pajak;
            $customers = Customer::find($msalesorder->customer_id);
            $this->customer = $customers->nama_customer;
        }
        if($this->pembayaran <> 'Dimuka Full'){
            $this->jumlah_total = 0;
            $this->dp = "DP";
        }else{
            if ($this->tipe_so=='Sewa'){
                $this->jumlah_total = VSalesOrderSewa::where('id',$this->so_id)
                ->where('status_so','Open')->sum(DB::raw('lama*harga_intax'));
                $this->dp = "Reg";
            }
            elseif($this->tipe_so =='Penjualan'){
                $this->jumlah_total = VPenjualan::where('m_penjualan_id',$this->so_id)
                ->where('status','Open')->sum(DB::raw('jumlah*harga_intax'));
                $this->dp = "Reg";
            }else{
                $this->jumlah_total = VSalesOrder::where('id',$this->so_id)
                ->where('status_so','Open')->sum(DB::raw('jumlah*harga_intax'));

                $totalconcretepump = Concretepump::where('m_salesorder_id', $this->so_id)
                                            ->where('concretepumps.status','Open')
                                            ->sum('concretepumps.harga_sewa');

                $this->jumlah_total = $this->jumlah_total + $totalconcretepump;
                $this->dp = "Reg";
            }
        }
        $this->dp_sebelum = Invoice::where('so_id', $this->so_id)
        ->where('tipe_so',$this->tipe_so)
        ->where('tipe','DP')
        ->where('status','open')->sum('total');
    }

    public function render()
    {
        return view('livewire.invoice.invoice-modal');
    }

    public function selecttgl(){
        if ($this->tipe_so=='Sewa'){
            
            $mobdemob = VSalesOrderSewa::where('tipe','None')->where('m_salesorder_sewa_id', $this->so_id)
            ->where('status_detail','Open')->sum(DB::raw('harga_intax*lama'));

            $totalsewa = 0;
            $datasewa = VSalesOrderSewa::where('m_salesorder_sewa_id', $this->so_id)->get();
            foreach ($datasewa as $sewa ){
                
                if ($sewa->satuan == 'Jam'){

                    $jumlahhari = VTimesheetSewa::where('d_so_id',$sewa->id)
                    ->whereBetween('tanggal',array(date_create($this->tgl_awal)->format('Y-m-d'),date_create($this->tgl_akhir)->format('Y-m-d')))
                    ->where('status','Open')
                    ->count('*');

                    if ($jumlahhari > 30){
                        $this->alert('error', 'Jumlah Hari Lebih dari 30, Perbarui SO', [
                            'position' => 'center'
                        ]);
                    }elseif($jumlahhari==30){
                        $totalsewa = $totalsewa + ($sewa->harga_intax*$sewa->lama);
                    }else{
                        $jumlahjam = VTimesheetSewa::where('d_so_id',$sewa->id)
                        ->whereBetween('tanggal',array(date_create($this->tgl_awal)->format('Y-m-d'),date_create($this->tgl_akhir)->format('Y-m-d')))
                        ->where('status','Open')
                        ->sum('lama');
                        $totaltimesheet = $jumlahjam / ($sewa->lama*60) * $sewa->harga_intax;
                        $totalsewa = $totalsewa + $totaltimesheet;
                    }
                }elseif ($sewa->satuan == 'Hari'){
                    $jumlahhari = VTimesheetSewa::where('d_so_id',$sewa->id)
                    ->whereBetween('tanggal',array(date_create($this->tgl_awal)->format('Y-m-d'),date_create($this->tgl_akhir)->format('Y-m-d')))
                    ->where('status','Open')
                    ->count('*');

                    $totalsewa = $totalsewa+($jumlahhari * $sewa->harga_intax);
                }elseif($sewa->satuan == 'Bln'){

                    $jumlahhari = VTimesheetSewa::where('d_so_id',$sewa->id)
                    ->whereBetween('tanggal',array(date_create($this->tgl_awal)->format('Y-m-d'),date_create($this->tgl_akhir)->format('Y-m-d')))
                    ->count('*');

                    $totalsewa = $totalsewa + ($jumlahhari/30 * $sewa->harga_intax);

                }
            }

            if ($this->pajak > 0){
                $this->jumlah_total = $mobdemob + $totalsewa;
            }else{
                $this->jumlah_penjualan_retail = $mobdemob + $totalsewa;
            }
        }
        elseif($this->tipe_so=='Penjualan'){
            $this->jumlah_total = VPenjualan::where('m_penjualan_id',$this->so_id)
                ->where('status','Open')->sum(DB::raw('jumlah*harga_intax'));
        }
        else{
            
            $jumlah_ticket = VTicketHeader::where('so_id', $this->so_id)
            ->where('status','Open')
            ->where(DB::raw('convert(date,jam_ticket)'),'>=',date_create($this->tgl_awal)->format('Y-m-d'))
            ->where(DB::raw('convert(date,jam_ticket)'),'<=',date_create($this->tgl_akhir)->format('Y-m-d'))
            ->sum(DB::raw('jumlah * harga_intax'));

            $jumlah_concrete = Concretepump::where('m_salesorder_id', $this->so_id)
            ->where('concretepumps.status','Open')
            ->whereBetween('concretepumps.tgl_sewa',array(date_create($this->tgl_awal)->format('Y-m-d'),date_create($this->tgl_akhir)->format('Y-m-d')))
            ->sum('concretepumps.harga_sewa');

            $this->jumlah_total = $jumlah_ticket + $jumlah_concrete;

            $tambahanbiaya = VTicketHeader::where('so_id', $this->so_id)
            ->where('status','Open')
            ->whereBetween(DB::raw('convert(date,jam_ticket)'),array(date_create($this->tgl_awal)->format('Y-m-d'),date_create($this->tgl_akhir)->format('Y-m-d')))
            ->sum('tambahan_biaya');

            $overtimeconcretepump = VTimesheetConcretepump::where('tipe','include mixer')->where('m_salesorder_id',$this->so_id)
            ->sum('biaya_overtime');

            $penjualanretail = PenjualanRetail::where('m_salesorder_id', $this->so_id)
            ->where('status_detail','Open')
            ->sum(DB::raw('jumlah * harga'));

            $this->jumlah_penjualan_retail = $tambahanbiaya + $penjualanretail + $overtimeconcretepump;

        }
        if ($this->jumlah_total + $this->jumlah_penjualan_retail > 0) {
            $this->dp = "Reg";
        }else{
            $this->dp = "DP";
        }
    }

    public function updatedTglAwal(){
        $this->selecttgl();
    }
    public function updatedTglAkhir(){
        $this->selecttgl();
    }

    public function save(){

        $bulan = ['','I','II','III','IV','V','VI','VII','VIII','IX','X','XI','XII'];

        $this->jumlah_total = str_replace(',', '', $this->jumlah_total);
        $this->jumlah_dp = str_replace(',', '', $this->jumlah_dp);
        $this->dp_sebelum = str_replace(',', '', $this->dp_sebelum);

        $this->validate();

        if ($this->pembayaran <> 'Dimuka Full' && $this->dp == 'Reg'){
            $this->validate([
                'tgl_awal' => 'required',
                'tgl_akhir' => 'required',
            ]);
        }

        if ($this->jumlah_total + $this->jumlah_penjualan_retail <= 0 && $this->jumlah_dp <=0){
            $this->alert('error', 'Jumlah Nol', [
                'position' => 'center'
            ]);
            exit();
        }

        DB::beginTransaction();

        try{

            if ($this->jumlah_total > 0 || $this->jumlah_dp > 0){

                $nomorterakhir = DB::table('invoices')->orderBy('id', 'DESC')
                ->where('tipe','<>','Retail')->first();

                if (is_null($nomorterakhir)){
                    $noinvoice = '0001/INV/BBM/'.$bulan[intval(date_create($this->tgl_cetak)->format('m'))].'/'.date_create($this->tgl_cetak)->format('Y');
                    $nokwitansi = '0001/KWT/BBM/'.$bulan[intval(date_create($this->tgl_cetak)->format('m'))].'/'.date_create($this->tgl_cetak)->format('Y');
                }else{
                    if (
                        date_create($nomorterakhir->tgl_cetak)->format('Y') == date('Y')
                    ) {
                        $noakhir = intval(substr($nomorterakhir->noinvoice, 0, 4)) + 1;
                        $noinvoice = substr('0000' . $noakhir, -4).'/INV/BBM/'.$bulan[intval(date_create($this->tgl_cetak)->format('m'))].'/'.date_create($this->tgl_cetak)->format('Y');
                        $nokwitansi = substr('0000' . $noakhir, -4).'/KWT/BBM/'.$bulan[intval(date_create($this->tgl_cetak)->format('m'))].'/'.date_create($this->tgl_cetak)->format('Y');
                    } else {
                        $noinvoice = '0001/INV/BBM/'.$bulan[intval(date_create($this->tgl_cetak)->format('m'))].'/'.date_create($this->tgl_cetak)->format('Y');
                        $nokwitansi = '0001/KWT/BBM/'.$bulan[intval(date_create($this->tgl_cetak)->format('m'))].'/'.date_create($this->tgl_cetak)->format('Y');
                    }
                }

                $totalinvoice = 0;
                if ($this->dp == "DP"){
                    $totalinvoice = $this->jumlah_dp;
                }else{
                    $totalinvoice = $this->jumlah_total;
                }

                DB::update("exec SP_Invoice '".$noinvoice."', '".
                $nokwitansi."', '".
                date_create($this->tgl_cetak)->format('Y-m-d')."','".
                $this->tipe_so."',".
                $this->so_id.",".
                $this->customer_id.",".
                $this->rekening_id.",'".
                $this->dp."',".
                $totalinvoice.",'".
                $this->tanda_tangan."','".
                date_create($this->tgl_awal)->format('Y-m-d')."','".
                date_create($this->tgl_akhir)->format('Y-m-d')."','".
                $this->keterangan."'");

            }
            if ($this->jumlah_penjualan_retail>0){

                $nomorterakhir = DB::table('invoices')->orderBy('id', 'DESC')
                ->where('tipe','Retail')->first();

                if (is_null($nomorterakhir)){
                    $noinvoice = '0001/'.$bulan[intval(date_create($this->tgl_cetak)->format('m'))].'/'.date_create($this->tgl_cetak)->format('Y');
                    $nokwitansi = '0001/'.$bulan[intval(date_create($this->tgl_cetak)->format('m'))].'/'.date_create($this->tgl_cetak)->format('Y');
                }else{
                    if (
                        date_create($nomorterakhir->tgl_cetak)->format('Y') == date('Y')
                    ) {
                        $noakhir = intval(substr($nomorterakhir->noinvoice, 0, 4)) + 1;
                        $noinvoice = substr('0000' . $noakhir, -4).'/'.$bulan[intval(date_create($this->tgl_cetak)->format('m'))].'/'.date_create($this->tgl_cetak)->format('Y');
                        $nokwitansi = substr('0000' . $noakhir, -4).'/'.$bulan[intval(date_create($this->tgl_cetak)->format('m'))].'/'.date_create($this->tgl_cetak)->format('Y');
                    } else {
                        $noinvoice = '0001/'.$bulan[intval(date_create($this->tgl_cetak)->format('m'))].'/'.date_create($this->tgl_cetak)->format('Y');
                        $nokwitansi = '0001/'.$bulan[intval(date_create($this->tgl_cetak)->format('m'))].'/'.date_create($this->tgl_cetak)->format('Y');
                    }
                }

                $sql = "exec SP_Invoice_Retail '".$noinvoice."', '".
                $nokwitansi."', '".
                date_create($this->tgl_cetak)->format('Y-m-d')."','".
                $this->tipe_so."',".
                $this->so_id.",".
                $this->customer_id.",".
                $this->rekening_id.
                ",'Retail',".
                $this->jumlah_penjualan_retail.",'".
                $this->tanda_tangan."','".
                date_create($this->tgl_awal)->format('Y-m-d')."','".
                date_create($this->tgl_akhir)->format('Y-m-d')."','".
                $this->keterangan."'";

                DB::table('Logsql')->insert([
                    'datasql' => $sql
                ]);
                
                DB::update($sql);
            }
            

            DB::commit();

            $this->closeModal();

            $this->alert('success', 'Save Success', [
                'position' => 'center'
            ]);

            $this->emitTo('invoice.invoice-table', 'pg:eventRefresh-default');

        }
        catch(Throwable $e){
            DB::rollBack();
            $this->alert('error', $e->getMessage(), [
                'position' => 'center'
            ]);
        }

    }

    public static function modalMaxWidth(): string
    {
        return '7xl';
    }
}
