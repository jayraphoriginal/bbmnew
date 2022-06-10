<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Mpajak;
use App\Models\MSalesorder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Concretepump;
use App\Models\Timesheet;
use PDF;

class PrintController extends Controller
{
    public function so($id){

        //return $id;

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

        $biayatambahan = DB::table('tickets')
                        ->join('d_salesorders','tickets.d_salesorder_id', 'd_salesorders.id')
                        ->where('d_salesorders.m_salesorder_id',$id)
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

        $data = 
        DB::table('tickets')
        ->select('tickets.*', 'm_salesorders.noso', 'customers.nama_customer', 'mutubetons.kode_mutu', 
        'kendaraans.nopol', DB::raw('drivers.nama_driver as driver'), 'rates.tujuan')
        ->join('kendaraans','tickets.kendaraan_id','kendaraans.id')
        ->join('drivers','tickets.driver_id','drivers.id')
        ->join('d_salesorders','tickets.d_salesorder_id','d_salesorders.id')
        ->join('mutubetons', 'd_salesorders.mutubeton_id','mutubetons.id')
        ->join('rates','d_salesorders.rate_id','rates.id')   
        ->join('m_salesorders','d_salesorders.m_salesorder_id', 'm_salesorders.id')
        ->join('customers','m_salesorders.customer_id','customers.id')     
        ->where('tickets.id',$id)
        ->get();

        // return $data;

        $customPaper = array(0,0,609.44,396.85);

        $pdf = PDF::loadView('print.ticket', array(
            'data' => $data,
        ))->setPaper($customPaper);
        return $pdf->stream();
    }

    public function sosewa($id){

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

        $data = DB::table('m_purchaseorders')
                ->select('m_purchaseorders.*', 'suppliers.nama_supplier', 'suppliers.alamat' ,'d_purchaseorders.*', 'barangs.nama_barang','satuans.satuan')
                ->join('suppliers','m_purchaseorders.supplier_id','suppliers.id')        
                ->join('d_purchaseorders','d_purchaseorders.m_purchaseorder_id','m_purchaseorders.id')
                ->join('barangs', 'd_purchaseorders.barang_id','barangs.id')
                ->join('satuans','barangs.satuan_id','satuans.id')
                ->where('m_purchaseorders.id',$id)
                ->get();
        $pajak = Mpajak::where('jenis_pajak', 'PPN')->first();
        // return $pajak;
        $pdf = PDF::loadView('print.PO', array(
            'data' => $data, 
            'pajak' => $pajak
        ));
        return $pdf->stream();

    }

    public function invoice($id){
    
        $invoice = Invoice::find($id);
        
        if ($invoice->tipe_so == 'Sewa'){

            $data = Invoice::select('invoices.*','m_salesorder_sewas.noso', 'm_salesorder_sewas.pajak' ,'customers.nama_customer', 
            'rekenings.norek', 'banks.nama_bank', 'rekenings.atas_nama',
            DB::raw('itemsewas.nama_item as uraian'), 'satuans.satuan', DB::raw('d_salesorder_sewas.lama as jumlah'), 'd_salesorder_sewas.harga_intax')
            ->join('m_salesorder_sewas','invoices.so_id', 'm_salesorder_sewas.id')
            ->join('customers','m_salesorder_sewas.customer_id','customers.id')
            ->join('d_invoices', 'invoices.id', 'd_invoices.invoice_id')
            ->join('d_salesorder_sewas', 'd_invoices.trans_id', 'd_salesorder_sewas.id')
            ->join('itemsewas', 'd_salesorder_sewas.itemsewa_id', 'itemsewas.id')
            ->join('satuans', 'd_salesorder_sewas.satuan_id','satuans.id')
            ->join('rekenings','invoices.rekening_id','rekenings.id')
            ->join('banks','rekenings.bank_id','bank.id')
            ->where('invoices.tipe_so','sewa')
            ->where('invoices.id',$id)
            ->get();

            
            $customPaper = array(0,0,609.44,396.85);

            $pdf = PDF::loadView('print.invoice', array(
                'data' => $data,
            ))->setPaper($customPaper);
            return $pdf->stream();
        }   
        else{
            $data = Invoice::select('invoices.*','m_salesorders.pajak', 'customers.nama_customer','v_detail_invoice.satuan', 'v_detail_invoice.tipe_detail', 
                        'v_detail_invoice.uraian', 'v_detail_invoice.jumlah', 'v_detail_invoice.harga_intax', 'rekenings.norek', 'banks.nama_bank','rekenings.atas_nama')
            ->join('customers','invoices.customer_id','customers.id', 'm_salesorders.pajak')
            ->join('m_salesorders','invoices.so_id','m_salesorders.id')
            ->join('rekenings','invoices.rekening_id','rekenings.id')
            ->join('banks','rekenings.bank_id','banks.id')
            ->leftjoin('v_detail_invoice','invoices.id','v_detail_invoice.invoice_id')
            ->where('invoices.id',$id)
            ->get();

            $customPaper = array(0,0,609.44,396.85);

            $pdf = PDF::loadView('print.invoice', array(
                'data' => $data
            ))->setPaper($customPaper);
            return $pdf->stream();
        }        
    } 

    public function concretepump($id){
    
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
}
