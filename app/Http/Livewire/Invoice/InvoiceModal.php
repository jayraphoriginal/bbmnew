<?php

namespace App\Http\Livewire\Invoice;

use App\Models\Concretepump;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\MSalesorder;
use App\Models\MSalesorderSewa;
use App\Models\PenjualanRetail;
use App\Models\VSalesOrderSewa;
use App\Models\VTicketHeader;
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
    public $tgl_awal, $tgl_akhir, $jumlah_total, $dp, $jumlah_dp, $jumlah_penjualan_retail;
    public $rekening, $dp_sebelum, $pajak, $customer_id, $rekening_id, $tgl_cetak, $tanda_tangan, $keterangan;

    protected $listeners = ['selectrekening' => 'selectrekening'];

    protected $rules =[
        'rekening_id' => 'required',
        'tgl_cetak' => 'required',
        'tgl_awal' => 'required',
        'tgl_akhir' => 'required',
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
            $this->customer_id = $msalesorder->customer_id;
            $this->noso = $msalesorder->noso;
            $this->pajak = $msalesorder->pajak;
            $customers = Customer::find($msalesorder->customer_id);
            $this->customer = $customers->nama_customer;
        }else{
            $msalesorder = MSalesorderSewa::find($this->so_id);
            $this->customer_id = $msalesorder->customer_id;
            $this->noso = $msalesorder->noso;
            $this->pajak = $msalesorder->pajak;
            $customers = Customer::find($msalesorder->customer_id);
            $this->customer = $customers->nama_customer;
        }
        $this->jumlah_total = 0;
        $this->dp = "DP";

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
                        ->sum('lama');
                        $totaltimesheet = $jumlahjam / ($sewa->lama*60) * $sewa->harga_intax;
                        $totalsewa = $totalsewa + $totaltimesheet;
                    }
                }elseif ($sewa->satuan == 'Hari'){
                    $jumlahhari = VTimesheetSewa::where('d_so_id',$sewa->id)
                    ->whereBetween('tanggal',array(date_create($this->tgl_awal)->format('Y-m-d'),date_create($this->tgl_akhir)->format('Y-m-d')))
                    ->count('*');

                    $totalsewa = $totalsewa+($jumlahhari / $sewa->lama * $sewa->harga_intax);
                }elseif($sewa->satuan == 'Bln'){

                    $jumlahhari = VTimesheetSewa::where('d_so_id',$sewa->id)
                    ->whereBetween('tanggal',array(date_create($this->tgl_awal)->format('Y-m-d'),date_create($this->tgl_akhir)->format('Y-m-d')))
                    ->count('*');

                    $totalsewa = $totalsewa + ($jumlahhari/30/$sewa->lama * $sewa->harga_intax);

                }
            }

            $this->jumlah_total = $mobdemob + $totalsewa;
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

            $penjualanretail = PenjualanRetail::where('m_salesorder_id', $this->so_id)
            ->where('status_detail','Open')
            ->sum(DB::raw('jumlah * harga'));

            $this->jumlah_penjualan_retail = $tambahanbiaya + $penjualanretail;

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

        $this->jumlah_total = str_replace(',', '', $this->jumlah_total);
        $this->jumlah_dp = str_replace(',', '', $this->jumlah_dp);
        $this->dp_sebelum = str_replace(',', '', $this->dp_sebelum);

        $this->validate();

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
                ->where('tipe','<>','Retail')->get();

                if (count($nomorterakhir) == 0){
                    $noinvoice = '0001/IV/'.date('m').'/'.date('Y');               
                }else{
                    if (
                        substr($nomorterakhir[0]->noinvoice, 8, 2) == date('m')
                        &&
                        substr($nomorterakhir[0]->noinvoice, 11, 4) == date('Y')
                    ) {
                        $noakhir = intval(substr($nomorterakhir[0]->noinvoice, 0, 4)) + 1;
                        $noinvoice = substr('0000' . $noakhir, -4) . '/IV/' . date('m') . '/' . date('Y');
                    } else {
                        $noinvoice = '0001/IV/' . date('m') . '/' . date('Y');
                    }
                }

                $totalinvoice = 0;
                if ($this->dp == "DP"){
                    $totalinvoice = $this->jumlah_dp;
                }else{
                    $totalinvoice = $this->jumlah_total;
                }

                DB::update("exec SP_Invoice '".$noinvoice."', '".
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
                ->where('tipe','Retail')->get();

                if (count($nomorterakhir) == 0){
                    $noinvoice = '0001/IVR/'.date('m').'/'.date('Y');               
                }else{
                    if (
                        substr($nomorterakhir[0]->noinvoice, 9, 2) == date('m')
                        &&
                        substr($nomorterakhir[0]->noinvoice, 12, 4) == date('Y')
                    ) {
                        $noakhir = intval(substr($nomorterakhir[0]->noinvoice, 0, 4)) + 1;
                        $noinvoice = substr('0000' . $noakhir, -4) . '/IVR/' . date('m') . '/' . date('Y');
                    } else {
                        $noinvoice = '0001/IVR/' . date('m') . '/' . date('Y');
                    }
                }

                
                DB::update("exec SP_Invoice_Retail '".$noinvoice."', '".
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
                $this->keterangan."'");

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
