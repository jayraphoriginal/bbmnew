<?php

namespace App\Http\Livewire\Invoice;

use App\Models\Coa;
use App\Models\Concretepump;
use App\Models\Customer;
use App\Models\DInvoice;
use App\Models\DSalesorderSewa;
use App\Models\Invoice;
use App\Models\Journal;
use App\Models\Mpajak;
use App\Models\MSalesorder;
use App\Models\MSalesorderSewa;
use App\Models\PenjualanRetail;
use App\Models\Ticket;
use App\Models\VTicket;
use App\Models\VTicketHeader;
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
    public $rekening, $dp_sebelum, $pajak, $customer_id;

    protected $listeners = ['selectrekening' => 'selectrekening'];

    protected $rules =[
        'invoice.rekening_id' => 'required',
        'tgl_awal' => 'required',
        'tgl_akhir' => 'required',
        'invoice.tanda_tangan' => 'required'
    ];

    public function selectrekening($id){
        $this->invoice->rekening_id=$id;
    }

    public function mount(){
        $this->invoice = new Invoice();
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

    public function updatedTglAwal(){

        if ($this->tipe_so=='Sewa'){
            $jumlah_total = DSalesorderSewa::where('d_salesorder_sewas.m_salesorder_sewa_id',$this->so_id)
            ->where('d_salesorder_sewas.status_detail','Open')
            ->sum(DB::raw('d_salesorder_sewas.lama * d_salesorder_sewas.harga_intax'));

            $this->jumlah_total = $jumlah_total;
        }
        else{
            $jumlah_ticket = VTicketHeader::where('so_id', $this->so_id)
            ->where('status','Open')
            ->whereBetween(DB::raw('convert(date,jam_ticket)'),array(date_create($this->tgl_awal)->format('Y-m-d'),date_create($this->tgl_akhir)->format('Y-m-d')))
            ->sum(DB::raw('jumlah * harga_intax'));

            $jumlah_concrete = Concretepump::where('m_salesorder_id', $this->so_id)
            ->where('concretepumps.status','Open')
            ->whereBetween(DB::raw('convert(date,concretepumps.created_at)'),array(date_create($this->tgl_awal)->format('Y-m-d'),date_create($this->tgl_akhir)->format('Y-m-d')))
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
            $this->dp = "";
        }else{
            $this->dp = "DP";
        }
    }
    public function updatedTglAkhir(){

        if ($this->tipe_so=='Sewa'){
            $jumlah_total = DSalesorderSewa::where('d_salesorder_sewas.m_salesorder_sewa_id',$this->so_id)
            ->where('d_salesorder_sewas.status_detail','Open')
            ->sum(DB::raw('d_salesorder_sewas.lama * d_salesorder_sewas.harga_intax'));

            $this->jumlah_total = $jumlah_total;
        }
        else{
            $jumlah_ticket = VTicketHeader::where('so_id', $this->so_id)
            ->where('status','Open')
            ->whereBetween(DB::raw('convert(date,jam_ticket)'),array(date_create($this->tgl_awal)->format('Y-m-d'),date_create($this->tgl_akhir)->format('Y-m-d')))
            ->sum(DB::raw('jumlah * harga_intax'));

            $jumlah_concrete = Concretepump::where('m_salesorder_id', $this->so_id)
            ->where('concretepumps.status','Open')
            ->whereBetween(DB::raw('convert(date,concretepumps.created_at)'),array(date_create($this->tgl_awal)->format('Y-m-d'),date_create($this->tgl_akhir)->format('Y-m-d')))
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
            $this->dp = "";
        }else{
            $this->dp = "DP";
        }
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

            if ($this->jumlah_total > 0){

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

                $this->invoice->noinvoice = $noinvoice;
                $this->invoice->tipe_so = $this->tipe_so;
                $this->invoice->so_id = $this->so_id;
                $this->invoice->tipe = $this->dp;
                $this->invoice->customer_id = $this->customer_id;
                
                if ($this->invoice->tipe == 'DP'){
                    $this->invoice->total = floatval($this->jumlah_dp);
                }else{
                    if (floatval($this->dp_sebelum) > floatval($this->jumlah_total)){
                        $this->invoice->total = floatval($this->jumlah_total);

                        DB::table('invoices')->where('so_id', $this->so_id)
                        ->where('tipe_so',$this->tipe_so)
                        ->where('tipe','DP')
                        ->where('status','open')
                        ->update([
                            'status' => 'change'
                        ]);
                    }else{
                        $this->invoice->total = floatval($this->jumlah_total) - floatval($this->jumlah_dp);
                        DB::table('invoices')->where('so_id', $this->so_id)
                        ->where('tipe_so',$this->tipe_so)
                        ->where('tipe','DP')
                        ->where('status','open')
                        ->update([
                            'status' => 'Finish'
                        ]);
                    }
                }
                $this->invoice->sisa_invoice = $this->invoice->total;
                $this->invoice->dpp = $this->invoice->total / (1+$this->pajak/100);
                $this->invoice->ppn = $this->invoice->dpp * $this->pajak/100;
                $this->invoice->status='Open';
                $this->invoice->save();

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

                $invoice = new Invoice();
                $invoice->noinvoice = $noinvoice;
                $invoice->tipe_so = $this->tipe_so;
                $invoice->so_id = $this->so_id;
                $invoice->tipe = 'Retail';
                $invoice->customer_id = $this->customer_id;
                $invoice->rekening_id = $this->invoice->rekening_id;
                $invoice->tanda_tangan = $this->invoice->tanda_tangan;
                $invoice->total = $this->jumlah_penjualan_retail;
                $invoice->sisa_invoice = $this->jumlah_penjualan_retail;
                $invoice->dpp = $this->jumlah_penjualan_retail;
                $invoice->ppn = 0;
                $invoice->status='Open';
                $invoice->save();

                PenjualanRetail::where('m_salesorder_id',$this->so_id)->update([
                    'status_detail'=> 'Finish'
                ]);

                $customer = Customer::find($this->invoice->customer_id);
                //Jurnal Piutang
                $journal = new Journal();
                $journal['tipe']='Invoice Retail';
                $journal['trans_id']=$this->ticket->id;
                $journal['tanggal_transaksi']=$this->ticket->jam_ticket->format('Y-m-d');
                $journal['coa_id']=$customer->coa_id;
                $journal['debet']=$this->invoice->total;
                $journal['kredit']=0;
                $journal->save();

                $coapenjualan = Coa::where('kode_akun','400002')->first();
                // Jurnal penjualan
                $journal = new Journal();
                $journal['tipe']='Invoice Retail';
                $journal['trans_id']=$this->ticket->id;
                $journal['tanggal_transaksi']=$this->ticket->jam_ticket->format('Y-m-d');
                $journal['coa_id']=$coapenjualan->id;
                $journal['debet']=0;
                $journal['kredit']=$this->invoice->total;
                $journal->save();

            }
            
            if ($this->tipe_so=='Sewa'){

                $customer = Customer::find($this->invoice->customer_id);

                $journal = new Journal();
                $journal['tipe']='Invoice Sewa';
                $journal['trans_id']=$this->ticket->id;
                $journal['tanggal_transaksi']=$this->ticket->jam_ticket->format('Y-m-d');
                $journal['coa_id']=$customer->coa_id;
                $journal['debet']=$this->invoice->total;
                $journal['kredit']=0;
                $journal->save();

                $pajak = Mpajak::where('jenis_pajak','PPN')->first();

                //Jurnal PPN Keluaran
                $journal = new Journal();
                $journal['tipe']='Ticket';
                $journal['trans_id']=$this->ticket->id;
                $journal['tanggal_transaksi']=$this->ticket->jam_ticket->format('Y-m-d');
                $journal['coa_id']=$pajak->coa_id_kredit;
                $journal['debet']=0;
                $journal['kredit']=$this->invoice->ppn;
                $journal->save();

                $coapenjualan = Coa::where('kode_akun','400002')->first();
                // Jurnal penjualan
                $journal = new Journal();
                $journal['tipe']='Invoice Sewa';
                $journal['trans_id']=$this->ticket->id;
                $journal['tanggal_transaksi']=$this->ticket->jam_ticket->format('Y-m-d');
                $journal['coa_id']=$coapenjualan->id;
                $journal['debet']=0;
                $journal['kredit']=$invoice->dpp;
                $journal->save();

                $sewas = DSalesorderSewa::where('d_salesorder_sewas.m_salesorder_sewa_id',$this->so_id)
                ->where('d_salesorder_sewas.status_detail','Open')
                ->get();

                foreach($sewas as $sewa){
                    $datasewa = DSalesorderSewa::find($sewa->id);
                    $datasewa['status_detail'] = 'Finish';
                    $datasewa->save();

                    $dinvoice = new DInvoice();
                    $dinvoice['invoice_id']=$this->invoice->id;
                    $dinvoice['tipe']='Sewa';
                    $dinvoice['trans_id']=$sewa->id;
                    $dinvoice['status_detail']='Open';
                    $dinvoice->save();
                }

            }else{

                $tickets = VTicketHeader::where('so_id', $this->so_id)
                ->where('status','Open')
                ->whereBetween(DB::raw('convert(date,jam_ticket)'),array(date_create($this->tgl_awal)->format('Y-m-d'),date_create($this->tgl_akhir)->format('Y-m-d')))
                ->get();

                $concretes = Concretepump::where('m_salesorder_id', $this->so_id)
                ->where('concretepumps.status','Open')
                ->whereBetween(DB::raw('convert(date,concretepumps.created_at)'),array(date_create($this->tgl_awal)->format('Y-m-d'),date_create($this->tgl_akhir)->format('Y-m-d')))
                ->get();

                foreach($tickets as $ticket){
                    $dataticket = Ticket::find($ticket->id);
                    $dataticket['status'] = 'Finish';
                    $dataticket->save();

                    $dinvoice = new DInvoice();
                    $dinvoice['invoice_id']=$this->invoice->id;
                    $dinvoice['tipe']='Ticket';
                    $dinvoice['trans_id']=$ticket->id;
                    $dinvoice['status_detail']='Open';
                    $dinvoice->save();
                }

                foreach($concretes as $concrete){
                    $dataconcrete = Concretepump::find($concrete->id);
                    $dataconcrete['status'] = 'Finish';
                    $dataconcrete->save();

                    $dinvoice = new DInvoice();
                    $dinvoice['invoice_id']=$this->invoice->id;
                    $dinvoice['tipe']='Concrete Pump';
                    $dinvoice['trans_id']=$concrete->id;
                    $dinvoice['status_detail']='Open';
                    $dinvoice->save();
                }
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
