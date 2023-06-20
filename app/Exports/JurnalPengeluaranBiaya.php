<?php

namespace App\Exports;

use App\Models\VJurnal;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;

class JurnalPengeluaranBiaya implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public $tgl_awal,$tgl_akhir;
    public function __construct($tgl_awal, $tgl_akhir)
    {
        $this->tgl_awal = $tgl_awal;
        $this->tgl_akhir = $tgl_akhir;
    }

    public function view(): View
    {
        $data = VJurnal::where('tipe','Pengeluaran Biaya')->where('tanggal_transaksi','>=',$this->tgl_awal)
        ->where('tanggal_transaksi','<=',$this->tgl_akhir)->get();

        return view('print.laporanjurnalpengeluaranbiaya', [
            'data' => $data,
            'tgl_awal' => $this->tgl_awal,
            'tgl_akhir' => $this->tgl_akhir
        ]);
    }
}
