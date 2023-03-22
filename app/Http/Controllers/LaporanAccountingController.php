<?php

namespace App\Http\Controllers;

use App\Models\TmpSaldoHutang;
use App\Models\TmpSaldoPiutang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PDF;

class LaporanAccountingController extends Controller
{
    public function piutang($tanggal){
    
        $user = Auth::user();
        if (!$user->hasPermissionTo('Laporan Rekap Piutang')){
            return abort(401);
        }
        DB::statement("SET NOCOUNT ON; Exec SP_Piutang '".$tanggal."'");

        $data = TmpSaldoPiutang::get();

        $pdf = PDF::loadView('print.piutangall', array(
            'data' => $data,
            'tanggal' => $tanggal
        ));
        return $pdf->setPaper('A4','potrait')->stream();
    }

    public function hutang($tanggal){
    
        $user = Auth::user();
        if (!$user->hasPermissionTo('Laporan Rekap Hutang')){
            return abort(401);
        }
        DB::statement("SET NOCOUNT ON; Exec SP_Hutang '".$tanggal."'");

        $data = TmpSaldoHutang::get();

        $pdf = PDF::loadView('print.hutangall', array(
            'data' => $data,
            'tanggal' => $tanggal
        ));
        return $pdf->setPaper('A4','potrait')->stream();
    } 
}
