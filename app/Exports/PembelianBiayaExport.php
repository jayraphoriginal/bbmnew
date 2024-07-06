<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromView;

class PembelianBiayaExport implements FromView
{
    public $tgl_awal, $tgl_akhir;
    public function __construct($tgl_awal, $tgl_akhir)
    {
        $this->tgl_awal = $tgl_awal;
        $this->tgl_akhir = $tgl_akhir;
    }

    public function view(): View
    {
        $user = Auth::user();
        if (!$user->hasPermissionTo('Laporan Pembelian Biaya')){
            return abort(401);
        }

        DB::statement("SET NOCOUNT ON; Exec SP_Pembelian_Biaya '".$this->tgl_awal."','".$this->tgl_akhir."'");

        $data = DB::table('tmp_pembelian_biaya')
        ->orderBy('tgl_masuk','asc')
        ->get();

        return view('print.laporanpembelianbiaya', [
            'data' => $data,
            'tgl_awal' => $this->tgl_awal,
            'tgl_akhir' => $this->tgl_akhir
        ]);
    }
}
