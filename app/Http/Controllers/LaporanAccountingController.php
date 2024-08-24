<?php

namespace App\Http\Controllers;

use App\Models\LabaRugi;
use App\Models\Neraca;
use App\Models\TmpSaldoHutang;
use App\Models\TmpSaldoPiutang;
use App\Models\TmpSaldoPiutangKaryawan;
use App\Models\TrialBalance;
use App\Models\VJurnalTanggal;
use App\Models\VJurnalUmum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PDF;

class LaporanAccountingController extends Controller
{
    public function piutang($tgl_awal, $tgl_akhir){
    
        $user = Auth::user();
        if (!$user->hasPermissionTo('Laporan Rekap Piutang')){
            return abort(401);
        }
        DB::statement("SET NOCOUNT ON; Exec SP_Piutang '".$tgl_awal."','".$tgl_akhir."'");

        $data = TmpSaldoPiutang::orderBy('nama_customer')->orwhere('saldo_awal','<>',0)
        ->orwhere('debet','<>',0)
        ->orwhere('kredit','<>',0)
        ->orwhere('saldo','<>',0)->get();

        $pdf = PDF::loadView('print.piutangall', array(
            'data' => $data,
            'tgl_awal' => $tgl_awal,
            'tgl_akhir' => $tgl_akhir
        ));
        return $pdf->setPaper('A4','landscape')->stream();
    }

    public function piutangkaryawan($tgl_awal, $tgl_akhir){
    
        $user = Auth::user();
        if (!$user->hasPermissionTo('Laporan Rekap Piutang Karyawan')){
            return abort(401);
        }
        DB::statement("SET NOCOUNT ON; Exec SP_PiutangKaryawan '".$tgl_awal."','".$tgl_akhir."'");

        $data = TmpSaldoPiutangKaryawan::where('saldo_awal','<>',0)
        ->orwhere('debet','<>',0)
        ->orwhere('kredit','<>',0)
        ->orwhere('saldo','<>',0)->get();

        $pdf = PDF::loadView('print.piutangkaryawan', array(
            'data' => $data,
            'tgl_awal' => $tgl_awal,
            'tgl_akhir' => $tgl_akhir
        ));
        return $pdf->setPaper('A4','potrait')->stream();
    }

    public function hutang($tgl_awal, $tgl_akhir){
    
        $user = Auth::user();
        if (!$user->hasPermissionTo('Laporan Rekap Hutang')){
            return abort(401);
        }
        DB::statement("SET NOCOUNT ON; Exec SP_Hutang '".$tgl_awal."','".$tgl_akhir."'");

        $data = TmpSaldoHutang::orderBy('nama_supplier')
        ->orwhere('saldo_awal','<>',0)
        ->orwhere('debet','<>',0)
        ->orwhere('kredit','<>',0)
        ->orwhere('saldo','<>',0)->get();

        $pdf = PDF::loadView('print.hutangall', array(
            'data' => $data,
            'tgl_awal' => $tgl_awal,
            'tgl_akhir' => $tgl_akhir
        ));
        return $pdf->setPaper('A4','potrait')->stream();
    }

    public function trialbalance($tahun,$bulan){
    
        $user = Auth::user();
        if (!$user->hasPermissionTo('Laporan Trial Balance')){
            return abort(401);
        }
        DB::statement("SET NOCOUNT ON; Exec SP_TrialBalance ".$tahun.",".$bulan."");

        $data = TrialBalance::orderby('kode_akun')->get();

        $pdf = PDF::loadView('print.trialbalance', array(
            'data' => $data,
            'tahun' => $tahun,
            'bulan' => $bulan
        ));
        return $pdf->setPaper('A4','landscape')->stream();
    }

    public function neraca($tanggal){
    
        $user = Auth::user();
        if (!$user->hasPermissionTo('Laporan Neraca')){
            return abort(401);
        }
        DB::statement("SET NOCOUNT ON; Exec sp_neraca '".$tanggal."'");

        $data = Neraca::orderby('level1')->orderBy('level2')->get();

        $pdf = PDF::loadView('print.neraca', array(
            'data' => $data,
            'tanggal' => $tanggal,
        ));
        return $pdf->setPaper('A4','landscape')->stream();
    }

    public function labarugi($tgl_awal,$tgl_akhir){
    
        $user = Auth::user();
        if (!$user->hasPermissionTo('Laporan Laba Rugi')){
            return abort(401);
        }
        DB::statement("SET NOCOUNT ON; Exec SP_LabaRugi '".$tgl_awal."','".$tgl_akhir."'");

        $data = LabaRugi::orderby('tipe')->orderBy('tipe2')->get();

        $pdf = PDF::loadView('print.labarugi', array(
            'data' => $data,
            'tgl_awal' => $tgl_awal,
            'tgl_akhir' => $tgl_akhir,
        ));
        return $pdf->setPaper('A4','portrait')->stream();
    }

    public function laporanjurnaltanggal($tgl_awal,$tgl_akhir){
        $user = Auth::user();
        if (!$user->hasPermissionTo('Laporan Jurnal per Tanggal')){
            return abort(401);
        }

        DB::statement("SET NOCOUNT ON; Exec SP_JurnalTanggal '".$tgl_awal."','".$tgl_akhir."'");
        $data = VJurnalTanggal::where('tanggal','>=',$tgl_awal)
        ->where('tanggal','<=',$tgl_akhir)
        ->orderBy('tanggal')->get();

        $pdf = PDF::loadView('print.laporanjurnaltanggal', array(
            'data' => $data,
            'tgl_awal' => $tgl_awal,
            'tgl_akhir' => $tgl_akhir
        ));
        
        return $pdf->setPaper('A4','potrait')->stream();
    }


    public function laporanclosing($tahun,$bulan){
    
        $user = Auth::user();
        if (!$user->hasPermissionTo('Laporan Closing')){
            return abort(401);
        }
        DB::statement("SET NOCOUNT ON; Exec SP_LaporanClosing ".$tahun.",".$bulan."");

        $data = DB::table('tmp_jurnal_tanggal')->get();

        $pdf = PDF::loadView('print.laporanclosing', array(
            'data' => $data,
            'tahun' => $tahun,
            'bulan' => $bulan
        ));
        return $pdf->setPaper('A4','landscape')->stream();
    }
}
