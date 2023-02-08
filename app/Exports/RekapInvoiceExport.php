<?php

namespace App\Exports;

use App\Models\VInvoiceHeader;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class RekapInvoiceExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */

    public $tipe, $tgl_awal, $tgl_akhir;

    public function __construct($tipe,$tgl_awal, $tgl_akhir)
    {
        $this->tipe = $tipe;
        $this->tgl_awal = $tgl_awal;
        $this->tgl_akhir = $tgl_akhir;
    }

    public function view(): View
    {
        if ($this->tipe == 'retail'){
            $data = VInvoiceHeader::where('tgl_cetak','>=',$this->tgl_awal)
            ->where('tgl_cetak','<=',$this->tgl_akhir)
            ->where('tipe','retail')->get();
        }
        else{
            $data = VInvoiceHeader::where('tgl_cetak','>=',$this->tgl_awal)
            ->where('tgl_cetak','<=',$this->tgl_akhir)
            ->where('tipe','<>','retail')->get();
        }
        return view('print.rekapinvoice', [
            'data' => $data,
            'tgl_awal' => $this->tgl_awal,
            'tgl_akhir' => $this->tgl_akhir
        ]);
    }
}
