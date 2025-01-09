<?php

namespace App\Http\Controllers;

use App\Models\VSuratJalanSum;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LaporanPenjualanController extends Controller
{
    public function laporanpenjualanbarang($tgl_awal,$tgl_akhir,$barang_id){
        $user = Auth::user();
        if (!$user->hasPermissionTo('Laporan Penjualan Barang')){
            return abort(401);
        }

        $data = VSuratJalanSum::where('tgl_pengiriman','>=',date_create($tgl_awal)->format(('d/M/Y')))
        ->where('tgl_pengiriman','<=',date_create($tgl_akhir)->format(('d/M/Y')))
        ->where('barang_id',$barang_id)
        ->orderBy('tgl_pengiriman','asc')
        ->get();
        
        // $pdf = PDF::loadView('print.laporanpenjualanbarang', array(
        //     'barang_id' => $barang_id,
        //     'data' => $data,
        //     'tgl_awal' => $tgl_awal,
        //     'tgl_akhir' => $tgl_akhir
        // ));

        // return $pdf->setPaper('A4','landscape')->stream();

        return View('print.laporanpenjualanbarang', array(
            'barang_id' => $barang_id,
            'data' => $data,
            'tgl_awal' => $tgl_awal,
            'tgl_akhir' => $tgl_akhir
        ));


    }

    public function laporanpenjualanbarangtanggal($tgl_awal,$tgl_akhir){
        $user = Auth::user();
        if (!$user->hasPermissionTo('Laporan Penjualan Barang')){
            return abort(401);
        }

        $data = VSuratJalanSum::where('tgl_pengiriman','>=',date_create($tgl_awal)->format(('d/M/Y')))
        ->where('tgl_pengiriman','<=',date_create($tgl_akhir)->format(('d/M/Y')))
        ->orderBy('tgl_pengiriman','asc')
        ->get();

        // $pdf = Pdf::loadView('print.laporanpenjualanbarang', array(
        //     'barang_id' => null,
        //     'data' => $data,
        //     'tgl_awal' => $tgl_awal,
        //     'tgl_akhir' => $tgl_akhir
        // ));

        // return $pdf->setPaper('A4','landscape')->stream();

        return View('print.laporanpenjualanbarang', array(
            'barang_id' => null,
            'data' => $data,
            'tgl_awal' => $tgl_awal,
            'tgl_akhir' => $tgl_akhir
        ));

    }

    public function penjualanbarangcustomer($tgl_awal,$tgl_akhir){

        $user = Auth::user();
        if (!$user->hasPermissionTo('Laporan Penjualan Barang')){
            return abort(401);
        }
        
         $datacustomer = VSuratJalanSum::select('nama_customer','nama_barang',DB::raw('harga_intax / (1+(pajak/100)) as harga'),'tujuan','satuan',DB::raw('sum(jumlah) as total'))
        ->groupBy('nama_customer',DB::raw('harga_intax / (1+(pajak/100))'),'nama_barang','tujuan','satuan')->get();

        // $pdf = PDF::loadView('print.rekappenjualanbarangcustomer', array(
        //     'datacustomer' => $datacustomer,
        //     'tgl_awal' => $tgl_awal,
        //     'tgl_akhir' => $tgl_akhir
        // ));
        // return $pdf->setPaper('A4','potrait')->stream();

        return View('print.rekappenjualanbarangcustomer', array(
            'datacustomer' => $datacustomer,
            'tgl_awal' => $tgl_awal,
            'tgl_akhir' => $tgl_akhir
        ));
    }
}
