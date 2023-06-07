<?php

namespace App\Exports;

use App\Models\VPengeluaranBiayaDetail;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;

class RekapPengeluaranBiaya implements FromView
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
        $data = VPengeluaranBiayaDetail::where('tgl_biaya','>=',$this->tgl_awal)
        ->where('tgl_biaya','<=',$this->tgl_akhir)->get();

        return view('print.rekappengeluaranbiaya', [
            'data' => $data,
            'tgl_awal' => $this->tgl_awal,
            'tgl_akhir' => $this->tgl_akhir
        ]);
    }
}
