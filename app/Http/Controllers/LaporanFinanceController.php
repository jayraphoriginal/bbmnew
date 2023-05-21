<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PDF;
class LaporanFinanceController extends Controller
{
    public function laporanrekapbiaya($tgl_awal,$tgl_akhir){
        
        $user = Auth::user();
        if (!$user->hasPermissionTo('Laporan Rekap Biaya')){
            return abort(401);
        }
        DB::statement("SET NOCOUNT ON; Exec SP_RekapBiaya '".$tgl_awal."','".$tgl_akhir."'");

        $data = DB::table('tmp_saldo_jurnal')->orderBy('kode_akun')->get();
      
        $pdf = PDF::loadView('print.laporanrekapbiaya', array(
            'data' => $data,
            'tgl_awal' => $tgl_awal,
            'tgl_akhir' => $tgl_akhir
        ));

        return $pdf->setPaper('A4','potrait')->stream();

    }

    public function laporanrekapsaldokasbank($tgl_awal, $tgl_akhir){
    
        $user = Auth::user();
        if (!$user->hasPermissionTo('Laporan Rekap Saldo Kas Bank')){
            return abort(401);
        }
        DB::statement("SET NOCOUNT ON; Exec SP_RekapSaldoKasBank '".$tgl_awal."','".$tgl_akhir."'");

        $data = DB::table('tmp_saldo_jurnal')->orderBy('kode_akun')->get();

        $pdf = PDF::loadView('print.laporanrekapsaldokasbank', array(
            'data' => $data,
            'tgl_awal' => $tgl_awal,
            'tgl_akhir' => $tgl_akhir
        ));
        return $pdf->setPaper('A4','potrait')->stream();
    }
}
