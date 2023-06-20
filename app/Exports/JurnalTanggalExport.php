<?php

namespace App\Exports;

use App\Models\VJurnalTanggal;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromView;

class JurnalTanggalExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */

    public $tgl_awal, $tgl_akhir;
    public function __construct($tgl_awal, $tgl_akhir)
    {
        $this->tgl_awal = $tgl_awal;
        $this->tgl_akhir = $tgl_akhir;
    }

    public function view(): View
    {
        $user = Auth::user();
        if (!$user->hasPermissionTo('Laporan Jurnal per Tanggal')){
            return abort(401);
        }

        DB::statement("SET NOCOUNT ON; Exec SP_JurnalTanggal '".$this->tgl_awal."','".$this->tgl_akhir."'");
        $data = VJurnalTanggal::where('tanggal','>=',$this->tgl_awal)
        ->where('tanggal','<=',$this->tgl_akhir)
        ->orderBy('tanggal')->get();

        return view('print.laporanjurnaltanggal', array(
            'data' => $data,
            'tgl_awal' => $this->tgl_awal,
            'tgl_akhir' => $this->tgl_akhir
        ));
    }

}
