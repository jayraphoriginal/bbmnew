<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromView;

class RekapHutangPajak implements FromView
{
    public $tgl_awal, $tgl_akhir;
    public function __construct($tgl_awal, $tgl_akhir)
    {
        $this->tgl_awal = $tgl_awal;
        $this->tgl_akhir = $tgl_akhir;
    }

    public function view(): View
    {
       
        DB::statement("SET NOCOUNT ON; Exec SP_RekapHutangPajak '".$this->tgl_awal."','".$this->tgl_akhir."'");

        $data = DB::table('tmp_saldo_jurnal')->orderBy('kode_akun')->get();

        return view('print.laporanrekaphutangpajak', [
            'data' => $data,
            'tgl_awal' => $this->tgl_awal,
            'tgl_akhir' => $this->tgl_akhir
        ]);
    }
}
