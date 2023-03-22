<?php

namespace App\Exports;

use App\Models\Coa;
use App\Models\VJurnalUmum;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromView;

class JurnalExport implements FromView
{
    public $coa_id, $tgl_awal, $tgl_akhir;
    public function __construct($coa_id,$tgl_awal, $tgl_akhir)
    {
        $this->coa_id = $coa_id;
        $this->tgl_awal = $tgl_awal;
        $this->tgl_akhir = $tgl_akhir;
    }

    public function view(): View
    {
        $user = Auth::user();
        if (!$user->hasPermissionTo('Laporan Jurnal Umum')){
            return abort(401);
        }

        $coa = Coa::find($this->coa_id);
        DB::update("Exec SP_GL '".$this->tgl_awal."','".$this->tgl_akhir."',".$this->coa_id."");
        $data = VJurnalUmum::where('tanggal','>=',$this->tgl_awal)
        ->where('tanggal','<=',$this->tgl_akhir)
        ->where('tipe','<>','Saldo Awal')
        ->orderBy('tanggal')->get();
        
        return view('print.laporanjurnalumum', [
            'data' => $data,
            'coa' => $coa,
            'tgl_awal' => $this->tgl_awal,
            'tgl_akhir' => $this->tgl_akhir
        ]);
    }
}
