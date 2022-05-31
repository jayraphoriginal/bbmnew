<?php

namespace App\Http\Controllers;

use App\Models\Mpajak;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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

        $pdf = PDF::loadView('print.SO', array(
            'data' => $data, 
            'concretepump' => $concretepump,
            'biayatambahan' => $biayatambahan,
        ));
        return $pdf->stream();
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
}
