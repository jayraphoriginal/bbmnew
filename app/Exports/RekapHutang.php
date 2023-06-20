<?php

namespace App\Exports;

use App\Models\TmpSaldoHutang;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;

class RekapHutang implements FromView
{
    public $tgl_awal, $tgl_akhir;
    public function __construct($tgl_awal, $tgl_akhir)
    {
        $this->tgl_awal = $tgl_awal;
        $this->tgl_akhir = $tgl_akhir;
    }

    public function view(): View
    {
       
        DB::statement("SET NOCOUNT ON; Exec SP_Hutang '".$this->tgl_awal."','".$this->tgl_akhir."'");

        $data = TmpSaldoHutang::orderBy('nama_supplier')->get();

        return view('print.hutangall', [
            'data' => $data,
            'tgl_awal' => $this->tgl_awal,
            'tgl_akhir' => $this->tgl_akhir
        ]);
    }
}
