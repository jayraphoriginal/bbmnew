<?php

namespace App\Http\Controllers;

use App\Models\Alat;
use App\Models\Barang;
use App\Models\Kendaraan;
use App\Models\TmpKartuStok;
use App\Models\VKartuStok;
use App\Models\VPemakaianBarang;
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
        DB::statement('SET NOCOUNT ON; exec SP_pivotkomposisi');

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

    public function laporanpemakaianbarang($tgl_awal,$tgl_akhir){
        $user = Auth::user();
        if (!$user->hasPermissionTo('Laporan Pemakaian Barang')){
            return abort(401);
        }

        $data = VPemakaianBarang::where('tgl_pemakaian','>=',$tgl_awal)
        ->where('tgl_pemakaian','<=',$tgl_akhir)->orderBy('tgl_pemakaian')->orderBy('jenis_pembebanan')->get();

        $pdf = PDF::loadView('print.laporanpemakaianbarang', array(
            'data' => $data,
            'tgl_awal' => $tgl_awal,
            'tgl_akhir' => $tgl_akhir
        ));

        return $pdf->setPaper('A4','landscape')->stream();

    }

    public function laporanpemakaianbarangbeban($tgl_awal,$tgl_akhir,$tipe,$beban_id){
        $user = Auth::user();
        if (!$user->hasPermissionTo('Laporan Pemakaian per Beban')){
            return abort(401);
        }

        DB::statement("SET NOCOUNT ON; Exec SP_PemakaianBarangBeban '".$tgl_awal."','".$tgl_akhir."','".$tipe."',".$beban_id);

        $data = DB::table('tmp_pemakaian_barang')->orderBy('tanggal')->get();

        if ($tipe == 'Beban Kendaraan'){
            $alken = Kendaraan::find($beban_id)->nopol;
        }else{
            $alken = Alat::find($beban_id)->nama_alat;
        }

        $pdf = PDF::loadView('print.laporanpemakaianbeban', array(
            'data' => $data,
            'tgl_awal' => $tgl_awal,
            'tgl_akhir' => $tgl_akhir,
            'alken' => $alken
        ));

        return $pdf->setPaper('A4','landscape')->stream();

    }

    public function laporanpemakaianperbarang($tgl_awal,$tgl_akhir,$tipe,$beban_id,$barang_id){
        $user = Auth::user();
        if (!$user->hasPermissionTo('Laporan Pemakaian per Barang')){
            return abort(401);
        }

        DB::statement("SET NOCOUNT ON; Exec SP_PemakaianPerBarang '".$tgl_awal."','".$tgl_akhir."','".$tipe."',".$beban_id.",".$barang_id);

        $data = DB::table('tmp_pemakaian_barang')->orderBy('tanggal')->get();
        $barang = Barang::find($barang_id);

        if ($tipe == 'Beban Kendaraan'){
            $alken = Kendaraan::find($beban_id)->nopol;
        }else{
            $alken = Alat::find($beban_id)->nama_alat;
        }

        $pdf = PDF::loadView('print.laporanpemakaianbarangbeban', array(
            'data' => $data,
            'tgl_awal' => $tgl_awal,
            'tgl_akhir' => $tgl_akhir,
            'alken' => $alken,
            'barang' => $barang
        ));

        return $pdf->setPaper('A4','landscape')->stream();

    }

    public function laporankartustokharian($tgl_awal,$tgl_akhir,$barang_id){
        $user = Auth::user();
        if (!$user->hasPermissionTo('Laporan Kartu Stok')){
            return abort(401);
        }

        DB::statement("SET NOCOUNT ON; Exec SP_KartuStokHarian '".$tgl_awal."','".$tgl_akhir."',".$barang_id."");
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

        DB::statement("SET NOCOUNT ON; Exec SP_KartuStokTanggal '".$tgl_awal."','".$tgl_akhir."'");

        $data = DB::table('tmp_stok_tanggal')->get();
      
        $pdf = PDF::loadView('print.laporanstoktanggal', array(
            'data' => $data,
            'tgl_awal' => $tgl_awal,
            'tgl_akhir' => $tgl_akhir
        ));

        return $pdf->setPaper('A4','potrait')->stream();

    }

    public function laporansaldopersediaan($tgl_awal,$tgl_akhir){
        
        $user = Auth::user();
        if (!$user->hasPermissionTo('Laporan Saldo Persediaan')){
            return abort(401);
        }
        DB::statement("SET NOCOUNT ON; Exec SP_SaldoPersediaanTanggal '".$tgl_awal."','".$tgl_akhir."'");

        $data = DB::table('tmp_saldo_jurnal')->get();
      
        $pdf = PDF::loadView('print.laporansaldopersediaan', array(
            'data' => $data,
            'tgl_awal' => $tgl_awal,
            'tgl_akhir' => $tgl_akhir
        ));

        return $pdf->setPaper('A4','potrait')->stream();

    }

    public function stokmaterial(){
        $data = DB::table('V_StokMaterial')->get();
        $pdf = PDF::loadView('print.laporanstokall', array(
            'data' => $data
        ));

        return $pdf->setPaper('A4','potrait')->stream();
    }
}
