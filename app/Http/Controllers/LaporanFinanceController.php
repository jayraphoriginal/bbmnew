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

    public function laporanwarkatmasuk($tgl_awal, $tgl_akhir){
    
        $user = Auth::user();
        if (!$user->hasPermissionTo('Laporan Warkat Masuk')){
            return abort(401);
        }

        $data = DB::table('v_penerimaan')
                    ->where('tgl_bayar','>=',date_create($tgl_awal)->format('Y-m-d'))
                    ->where('tgl_bayar','<=',date_create($tgl_akhir)->format('Y-m-d'))
                    ->whereIn('tipe',['cheque','giro'])->get();

        $pdf = PDF::loadView('print.laporangiromasuk', array(
            'data' => $data,
            'tgl_awal' => $tgl_awal,
            'tgl_akhir' => $tgl_akhir
        ));
        return $pdf->setPaper('A4','landscape')->stream();
    }

    public function laporanwarkatkeluar($tgl_awal, $tgl_akhir){
    
        $user = Auth::user();
        if (!$user->hasPermissionTo('Laporan Warkat Keluar')){
            return abort(401);
        }

        $data = DB::table('v_pembayaran')
                    ->where('tgl_bayar','>=',date_create($tgl_awal)->format('Y-m-d'))
                    ->where('tgl_bayar','<=',date_create($tgl_akhir)->format('Y-m-d'))
                    ->whereIn('tipe',['cheque','giro'])->get();

        $pdf = PDF::loadView('print.laporangirokeluar', array(
            'data' => $data,
            'tgl_awal' => $tgl_awal,
            'tgl_akhir' => $tgl_akhir
        ));
        return $pdf->setPaper('A4','landscape')->stream();
    }
}
