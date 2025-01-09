<?php

namespace App\Http\Controllers;

use App\Models\VPembelianDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PDF;

class LaporanPembelianController extends Controller
{

    public function laporanpembelianbarang($tgl_awal,$tgl_akhir,$barang_id){

        $user = Auth::user();
        if (!$user->hasPermissionTo('Laporan Pembelian Barang')){
            return abort(401);
        }

        $data = VPembelianDetail::where('barang_id', $barang_id)
        ->where(DB::raw('convert(date,tgl_masuk)'),'>=',$tgl_awal)
        ->where(DB::raw('convert(date,tgl_masuk)'),'<=',$tgl_akhir)
        ->orderBy('V_PembelianDetail.tgl_masuk')
        ->get();

        // $pdf = PDF::loadView('print.laporanpembelianbarang', array(
        //     'data' => $data,
        //     'tgl_awal' => $tgl_awal,
        //     'tgl_akhir' => $tgl_akhir
        // ));

        // return $pdf->setPaper('A4','landscape')->stream();

        return View('print.laporanpembelianbarang', array(
            'data' => $data,
            'tgl_awal' => $tgl_awal,
            'tgl_akhir' => $tgl_akhir
        ));
    }

    public function laporanpembelianppn($tgl_awal,$tgl_akhir){

        $user = Auth::user();
        if (!$user->hasPermissionTo('Laporan Pembelian PPN')){
            return abort(401);
        }

        $data = VPembelianDetail::where(DB::raw('convert(date,tgl_masuk)'),'>=',$tgl_awal)
        ->where(DB::raw('convert(date,tgl_masuk)'),'<=',$tgl_akhir)
        ->where('ppn','>',0)
        ->orderBy('V_PembelianDetail.tgl_masuk')
        ->get();

        // $pdf = PDF::loadView('print.laporanpembelian', array(
        //     'data' => $data,
        //     'tgl_awal' => $tgl_awal,
        //     'tgl_akhir' => $tgl_akhir
        // ));

        // return $pdf->setPaper('A4','landscape')->stream();

       return View('print.laporanpembelian', array(
            'data' => $data,
            'tgl_awal' => $tgl_awal,
            'tgl_akhir' => $tgl_akhir
        ));
    }

    public function laporanpembelianbiaya($tgl_awal,$tgl_akhir){

        $user = Auth::user();
        if (!$user->hasPermissionTo('Laporan Pembelian Biaya')){
            return abort(401);
        }

        DB::statement("SET NOCOUNT ON; Exec SP_Pembelian_Biaya '".$tgl_awal."','".$tgl_akhir."'");

        $data = DB::table('tmp_pembelian_biaya')
        ->orderBy('tgl_masuk','asc')
        ->get();

        // $pdf = PDF::loadView('print.laporanpembelianbiaya', array(
        //     'data' => $data,
        //     'tgl_awal' => $tgl_awal,
        //     'tgl_akhir' => $tgl_akhir
        // ));

        // return $pdf->setPaper('A4','landscape')->stream();

        return View('print.laporanpembelianbiaya', array(
            'data' => $data,
            'tgl_awal' => $tgl_awal,
            'tgl_akhir' => $tgl_akhir
        ));
    }

    
}
