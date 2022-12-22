<?php

namespace App\Http\Controllers;

use App\Http\Livewire\Rate\RateSelect;
use App\Models\BahanBakar;
use App\Models\Invoice;
use App\Models\Mpajak;
use App\Models\MSalesorder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Concretepump;
use App\Models\Customer;
use App\Models\Driver;
use App\Models\DSalesorder;
use App\Models\GajiRate;
use App\Models\Invoicedp;
use App\Models\Kendaraan;
use App\Models\PemakaianBbm;
use App\Models\PengisianBbm;
use App\Models\Rate;
use App\Models\Supplier;
use App\Models\TambahanBbm;
use App\Models\Ticket;
use App\Models\Timesheet;
use App\Models\TmpGajiDriver;
use App\Models\TmpPenjualanBulanan;
use App\Models\TmpReportTicket;
use App\Models\VConcretepump;
use App\Models\VHutang;
use App\Models\VPembayaran;
use App\Models\VPembelianDetail;
use App\Models\VPengeluaranBiaya;
use App\Models\VPengeluaranBiayaDetail;
use App\Models\VPengisianBbm;
use App\Models\VPrintInvoice;
use App\Models\VTicket;
use App\Models\VTicketHeader;
use App\Models\VTimesheetSewa;
use Illuminate\Support\Facades\Auth;
use Riskihajar\Terbilang\Facades\Terbilang;
use PDF;

class PrintController extends Controller
{
    public function so($id){

        //return $id;

        $user = Auth::user();
        if (!$user->hasPermissionTo('PO Customer')){
            return abort(401);
        }

        $data = DB::table('m_salesorders')
                ->select('m_salesorders.*', 'd_salesorders.*', 'customers.nama_customer', 'customers.alamat', 
                'customers.notelp','customers.nofax','mutubetons.kode_mutu', 
                'rates.tujuan')
                ->join('customers','m_salesorders.customer_id','customers.id')        
                ->join('d_salesorders','m_salesorders.id','d_salesorders.m_salesorder_id')
                ->join('mutubetons', 'd_salesorders.mutubeton_id','mutubetons.id')
                ->join('rates','d_salesorders.rate_id','rates.id')
                ->where('m_salesorders.id',$id)
                ->get();
        
        $concretepump = DB::table('concretepumps')->where('m_salesorder_id',$id)
        ->sum('harga_sewa');

        $biayatambahan = VTicketHeader::where('so_id',$id)
        ->sum('tambahan_biaya');

        if (count($data) > 0){
            $pdf = PDF::loadView('print.SO', array(
                'data' => $data, 
                'concretepump' => $concretepump,
                'biayatambahan' => $biayatambahan,
            ));
            return $pdf->stream();
        }else{
            return abort(404);
        }
       
    }

    public function ticket($id){
        
        $user = Auth::user();
        if (!$user->hasPermissionTo('Ticket')){
            return abort(401);
        }

        DB::update('Exec SP_ReportTicket '.$id);
        $data = TmpReportTicket::where('id',$id)->get();

        $customPaper = array(0,0,609.44,396.85);

        $pdf = PDF::loadView('print.ticket', array(
            'data' => $data,
        ))->setPaper($customPaper);
        return $pdf->stream();
    }

    public function sosewa($id){

        $user = Auth::user();
        if (!$user->hasPermissionTo('Sales Order Sewa')){
            return abort(401);
        }

        $data = DB::table('m_salesorder_sewas')
                ->select('m_salesorder_sewas.*', 'd_salesorder_sewas.*', 'customers.nama_customer', 'customers.alamat', 
                'customers.notelp','customers.nofax','itemsewas.nama_item', 
                'satuans.satuan')                   
                ->join('customers','m_salesorder_sewas.customer_id','customers.id')        
                ->join('d_salesorder_sewas','m_salesorder_sewas.id','d_salesorder_sewas.m_salesorder_sewa_id')
                ->join('itemsewas', 'd_salesorder_sewas.itemsewa_id','itemsewas.id')
                ->join('satuans','d_salesorder_sewas.satuan_id','satuans.id')
                ->where('m_salesorder_sewas.id',$id)
                ->get();

        $pdf = PDF::loadView('print.SOSewa', array(
            'data' => $data,
        ));
        return $pdf->stream();

       // return $data;

    }

    public function po($id){

        $user = Auth::user();
        if (!$user->hasPermissionTo('Purchase Order')){
            return abort(401);
        }

        $data = DB::table('m_purchaseorders')
                ->select('m_purchaseorders.*', 'suppliers.nama_supplier', 'suppliers.alamat' ,'d_purchaseorders.*', 'barangs.nama_barang','satuans.satuan')
                ->join('suppliers','m_purchaseorders.supplier_id','suppliers.id')        
                ->join('d_purchaseorders','d_purchaseorders.m_purchaseorder_id','m_purchaseorders.id')
                ->join('barangs', 'd_purchaseorders.barang_id','barangs.id')
                ->join('satuans','barangs.satuan_id','satuans.id')
                ->where('m_purchaseorders.id',$id)
                ->get();
        $pajak = Mpajak::where('jenis_pajak', 'PPN')->first();
         //return $data;
        $pdf = PDF::loadView('print.PO', array(
            'data' => $data, 
            'pajak' => $pajak
        ));
        return $pdf->stream();

    }

    public function kwitansi($id){

        $user = Auth::user();
        if (!$user->hasPermissionTo('Invoice')){
            return abort(401);
        }

        DB::update("exec SP_DetailInvoice '".$id."'");

        $data = VPrintInvoice::where('id', $id)->get();
        $dp = Invoicedp::join('invoices','invoicedps.invoicedp_id','invoices.id')->where('invoice_id',$id)->sum('total');

        
        $terbilang = Terbilang::make($data[0]->total);

        $customPaper = array(0,0,609.44,396.85);

        $pdf = PDF::loadView('print.kwitansi', array(
            'data' => $data,
            'terbilang' => $terbilang,
            'dp' => $dp
        ))->setPaper($customPaper);
        return $pdf->stream();        
    }

    public function invoice($id){

        $user = Auth::user();
        if (!$user->hasPermissionTo('Invoice')){
            return abort(401);
        }
    
        DB::update("exec SP_DetailInvoice '".$id."'");

        $data = VPrintInvoice::where('id', $id)->get();
        $dp = Invoicedp::join('invoices','invoicedps.invoicedp_id','invoices.id')->where('invoice_id',$id)->sum('total');

        $terbilang = Terbilang::make($data[0]->total);

        $customPaper = array(0,0,609.44,396.85);

        $pdf = PDF::loadView('print.invoice', array(
            'data' => $data,
            'terbilang' => $terbilang,
            'dp' => $dp
        ))->setPaper($customPaper);
        return $pdf->stream();

    } 

    public function concretepump($id){

        $user = Auth::user();
        if (!$user->hasPermissionTo('Concrete Pump')){
            return abort(401);
        }
    
        $header = Concretepump::select('concretepumps.*','customers.nama_customer','kendaraans.nopol','drivers.nama_driver','rates.tujuan')
                ->join('m_salesorders','concretepumps.m_salesorder_id','m_salesorders.id')
                ->join('customers','m_salesorders.customer_id','customers.id')
                ->join('kendaraans','concretepumps.kendaraan_id','kendaraans.id')
                ->join('drivers','concretepumps.driver_id','drivers.id')    
                ->join('rates','concretepumps.rate_id','rates.id')
                ->where('concretepumps.id',$id)
                ->first();

        //  return $header;

        $detail = Timesheet::select('timesheets.*')
                ->where('timesheets.d_so_id',$id)
                ->orderBy('id','desc')
                ->first();

        $customPaper = array(0,0,609.44,396.85);

        $pdf = PDF::loadView('print.concretepump', array(
            'header' => $header,
            'detail' => $detail
        ))->setPaper($customPaper);
        return $pdf->stream();
    }
    
    public function buktikas($id){
        
        $user = Auth::user();
        if (!$user->hasPermissionTo('Pembayaran Pembelian')){
            return abort(401);
        }

        $data = VPembayaran::find($id);

        $terbilang = Terbilang::make($data->jumlah);
       
        $customPaper = array(0,0,391.1811,277.795);

        $pdf = PDF::loadView('print.buktikas', array(
            'data' => $data,
            'terbilang' => $terbilang
        ))->setPaper($customPaper);
        return $pdf->stream();
    }

    public function buktikasbiaya($id){
        
        $user = Auth::user();
        if (!$user->hasPermissionTo('Pembayaran Pembelian')){
            return abort(401);
        }

        $data = VPengeluaranBiayaDetail::where('id',$id)->get();

        $terbilang = Terbilang::make($data[0]->total);
       
        $customPaper = array(0,0,391.1811,277.795);

        $pdf = PDF::loadView('print.buktikasbiaya', array(
            'data' => $data,
            'terbilang' => $terbilang
        ))->setPaper($customPaper);
        return $pdf->stream();
    }

    public function timesheet($so_id){
        $user = Auth::user();
        if (!$user->hasPermissionTo('Timesheet')){
            return abort(401);
        }

        $data = VTimesheetSewa::where('m_salesorder_sewa_id',$so_id)->get();

        $pdf = PDF::loadView('print.rekaptimesheet', array(
            'data' => $data,
        ));
        return $pdf->setPaper('A4','portrait')->stream();
    }

}
