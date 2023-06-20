<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;

class WarkatMasuk implements FromView
{
    public $tgl_awal, $tgl_akhir;
    public function __construct($tgl_awal, $tgl_akhir)
    {
        $this->tgl_awal = $tgl_awal;
        $this->tgl_akhir = $tgl_akhir;
    }

    public function view(): View
    {
       
        $data = DB::table('v_penerimaan')
                    ->where('tgl_bayar','>=',date_create($this->tgl_awal)->format('Y-m-d'))
                    ->where('tgl_bayar','<=',date_create($this->tgl_akhir)->format('Y-m-d'))
                    ->whereIn('tipe',['cheque','giro'])->get();

        return view('print.laporangiromasuk', [
            'data' => $data,
            'tgl_awal' => $this->tgl_awal,
            'tgl_akhir' => $this->tgl_akhir
        ]);
    }
}
