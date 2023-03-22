<?php

namespace App\Exports;

use App\Models\VPembelianDetail;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromView;

class PembelianExport implements FromView
{
    public $tgl_awal, $tgl_akhir, $barang_id;
    public function __construct($barang_id,$tgl_awal, $tgl_akhir)
    {
        $this->barang_id = $barang_id;
        $this->tgl_awal = $tgl_awal;
        $this->tgl_akhir = $tgl_akhir;
    }

    public function view(): View
    {
        $user = Auth::user();
        if (!$user->hasPermissionTo('Laporan Pembelian Barang')){
            return abort(401);
        }

        $data = VPembelianDetail::where('barang_id', $this->barang_id)
        ->where(DB::raw('convert(date,tgl_masuk)'),'>=',$this->tgl_awal)
        ->where(DB::raw('convert(date,tgl_masuk)'),'<=',$this->tgl_akhir)
        ->orderBy('V_PembelianDetail.tgl_masuk')
        ->get();

        return view('print.laporanpembelianbarang', [
            'data' => $data,
            'tgl_awal' => $this->tgl_awal,
            'tgl_akhir' => $this->tgl_akhir
        ]);
    }
}
