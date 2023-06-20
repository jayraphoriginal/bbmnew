<?php

namespace App\Exports;

use App\Models\TmpSaldoPiutangKaryawan;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;

class RekapPiutangKaryawan implements FromView
{
    public $tgl_awal, $tgl_akhir;
    public function __construct($tgl_awal, $tgl_akhir)
    {
        $this->tgl_awal = $tgl_awal;
        $this->tgl_akhir = $tgl_akhir;
    }

    public function view(): View
    {
       
        DB::statement("SET NOCOUNT ON; Exec SP_PiutangKaryawan '".$this->tgl_awal."','".$this->tgl_akhir."'");

        $data = TmpSaldoPiutangKaryawan::get();

        return view('print.piutangkaryawan', [
            'data' => $data,
            'tgl_awal' => $this->tgl_awal,
            'tgl_akhir' => $this->tgl_akhir
        ]);
    }
}
