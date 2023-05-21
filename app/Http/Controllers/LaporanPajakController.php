<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PDF;

class LaporanPajakController extends Controller
{
    public function laporanhutangpajak($tgl_awal, $tgl_akhir){
    
        $user = Auth::user();
        if (!$user->hasPermissionTo('Laporan Hutang Pajak')){
            return abort(401);
        }
        DB::statement("SET NOCOUNT ON; Exec SP_RekapHutangPajak '".$tgl_awal."','".$tgl_akhir."'");

        $data = DB::table('tmp_saldo_jurnal')->orderBy('kode_akun')->get();

        $pdf = PDF::loadView('print.laporanrekaphutangpajak', array(
            'data' => $data,
            'tgl_awal' => $tgl_awal,
            'tgl_akhir' => $tgl_akhir
        ));
        return $pdf->setPaper('A4','potrait')->stream();
    }

    public function laporanuangmukapajak($tgl_awal, $tgl_akhir){
    
        $user = Auth::user();
        if (!$user->hasPermissionTo('Laporan Uang Muka Pajak')){
            return abort(401);
        }
        DB::statement("SET NOCOUNT ON; Exec SP_RekapUangMukaPajak '".$tgl_awal."','".$tgl_akhir."'");

        $data = DB::table('tmp_saldo_jurnal')->orderBy('kode_akun')->get();

        $pdf = PDF::loadView('print.laporanrekapuangmukapajak', array(
            'data' => $data,
            'tgl_awal' => $tgl_awal,
            'tgl_akhir' => $tgl_akhir
        ));
        return $pdf->setPaper('A4','potrait')->stream();
    }
}
