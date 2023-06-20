<?php

namespace App\Exports;

use App\Models\TrialBalance as ModelsTrialBalance;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;

class TrialBalance implements FromView
{
    public $tahun, $bulan;
    public function __construct($tahun, $bulan)
    {
        $this->tahun = $tahun;
        $this->bulan = $bulan;
    }

    public function view(): View
    {
       
        DB::statement("SET NOCOUNT ON; Exec SP_TrialBalance ".$this->tahun.",".$this->bulan."");

        $data = ModelsTrialBalance::orderby('kode_akun')->get();

        return view('print.trialbalance', [
            'data' => $data,
            'tahun' => $this->tahun,
            'bulan' => $this->bulan
        ]);
    }
}
