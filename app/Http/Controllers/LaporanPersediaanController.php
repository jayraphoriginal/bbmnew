<?php

namespace App\Http\Controllers;

use App\Models\TmpKartuStok;
use App\Models\VKartuStok;
use App\Models\VStok;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PDF;

class LaporanPersediaanController extends Controller
{
    public function laporankomposisi(){

        $user = Auth::user();
        if (!$user->hasPermissionTo('Laporan Komposisi')){
            return abort(401);
        }
        DB::update('exec SP_pivotkomposisi');

        $data = DB::table('tmppivot')->orderBy(DB::raw('left(deskripsi,4)'))->orderBy('status')->get();

        //return $data;

        $pdf = PDF::loadView('print.laporankomposisi', array(
            'data' => $data,
        ));

        return $pdf->setPaper('A4','potrait')->stream();
    }

    public function laporanstokall(){
        $user = Auth::user();
        if (!$user->hasPermissionTo('Laporan Stok All')){
            return abort(401);
        }

        $data = VStok::all();

        $pdf = PDF::loadView('print.laporanstokall', array(
            'data' => $data,
        ));

        return $pdf->setPaper('A4','potrait')->stream();

    }

    public function laporankartustok($tgl_awal,$tgl_akhir,$barang_id){
        $user = Auth::user();
        if (!$user->hasPermissionTo('Laporan Kartu Stok')){
            return abort(401);
        }

        $data = VKartuStok::where('tanggal','>=',$tgl_awal)
        ->where('tanggal','<=',$tgl_akhir)
        ->where('barang_id',$barang_id)
        ->orderBy('tanggal','asc')
        ->orderBy('increase','desc')
        ->orderBy('trans_id','asc')->get();

        $pdf = PDF::loadView('print.laporankartustok', array(
            'data' => $data,
            'tgl_awal' => $tgl_awal,
            'tgl_akhir' => $tgl_akhir
        ));

        return $pdf->setPaper('A4','potrait')->stream();

    }

    public function laporankartustokharian($tgl_awal,$tgl_akhir,$barang_id){
        $user = Auth::user();
        if (!$user->hasPermissionTo('Laporan Kartu Stok')){
            return abort(401);
        }

        DB::update("Exec SP_KartuStokHarian '".$tgl_awal."','".$tgl_akhir."',".$barang_id."");
        $data = TmpKartuStok::orderBy('tanggal','asc')->get();

        $pdf = PDF::loadView('print.laporankartustokharian', array(
            'data' => $data,
            'tgl_awal' => $tgl_awal,
            'tgl_akhir' => $tgl_akhir
        ));

        return $pdf->setPaper('A4','potrait')->stream();

    }

    public function laporanstokbarangtanggal($tgl_awal,$tgl_akhir){
        
        $user = Auth::user();
        if (!$user->hasPermissionTo('Laporan Stok Tanggal')){
            return abort(401);
        }

        $data = VKartuStok::where('tanggal','>=',$tgl_awal)->where('tanggal','<=',$tgl_akhir)
        ->select('barang_id', 'nama_barang',DB::raw("dbo.F_GetStokAwal(barang_id,'".$tgl_awal."') as stok_awal"), DB::raw('isnull(sum(increase),0) as increase'),DB::raw('isnull(sum(decrease),0) as decrease'),DB::raw('isnull(sum(increase-decrease),0) as Stok'),'modal')
        ->groupBy('barang_id', 'nama_barang','modal')->orderBy('barang_id','asc')->get();
      
        $pdf = PDF::loadView('print.laporanstoktanggal', array(
            'data' => $data,
            'tgl_awal' => $tgl_awal,
            'tgl_akhir' => $tgl_akhir
        ));

        return $pdf->setPaper('A4','potrait')->stream();

    }
}
