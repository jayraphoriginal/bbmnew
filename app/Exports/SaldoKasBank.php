<?php

namespace App\Exports;

use App\Models\Rekening;
use App\Models\VSaldoRekening;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;

class SaldoKasBank implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public $tgl_awal, $tgl_akhir,$rekening_id;
    public function __construct($tgl_awal, $tgl_akhir,$rekening_id)
    {
        $this->tgl_awal = $tgl_awal;
        $this->tgl_akhir = $tgl_akhir;
        $this->rekening_id= $rekening_id;
    }

    public function view(): View
    {
        $rekening = Rekening::join('banks','rekenings.bank_id','banks.id')
        ->where('rekenings.id',$this->rekening_id)->get();
    
        //return "Exec SP_SaldoKasBank '".$tgl_awal."','".$tgl_akhir."',".$rekening_id;

        DB::statement("SET NOCOUNT ON; Exec SP_SaldoKasBank '".$this->tgl_awal."','".$this->tgl_akhir."',".$this->rekening_id."");
        $data = VSaldoRekening::where('tanggal','>=',$this->tgl_awal)
        ->where('tanggal','<=',$this->tgl_akhir)
        ->where('tipe','<>','Saldo Awal')
        ->orderBy('tanggal')->get();   

        return view('print.laporansaldorekening', [
            'data' => $data,
            'rekening' => $rekening,
            'tgl_awal' => $this->tgl_awal,
            'tgl_akhir' => $this->tgl_akhir
        ]);
    }
}
