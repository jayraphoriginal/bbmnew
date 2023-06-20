<?php

namespace App\Exports;

use App\Models\TmpSaldoPiutang;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;

class RekapPiutang implements FromView
{
    public $tgl_awal, $tgl_akhir;
    public function __construct($tgl_awal, $tgl_akhir)
    {
        $this->tgl_awal = $tgl_awal;
        $this->tgl_akhir = $tgl_akhir;
    }

    public function view(): View
    {
       
        DB::statement("SET NOCOUNT ON; Exec SP_Piutang '".$this->tgl_awal."','".$this->tgl_akhir."'");

        $data = TmpSaldoPiutang::orderBy('nama_customer')->get();

        return view('print.piutangall', [
            'data' => $data,
            'tgl_awal' => $this->tgl_awal,
            'tgl_akhir' => $this->tgl_akhir
        ]);
    }
}
