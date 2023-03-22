<?php

namespace App\Exports;

use App\Models\VTicketHeaderAll;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromView;

class RekapTicketExport implements FromView
{
    /**
     * 
     
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
        $data = VTicketHeaderAll::orderBy('V_TicketHeaderAll.noticket')
        ->where(DB::raw('convert(date,jam_ticket)'),'>=',date_create($this->tgl_awal)->format('Y-m-d'))
        ->where(DB::raw('convert(date,jam_ticket)'),'<=',date_create($this->tgl_akhir)->format('Y-m-d'))
        ->get();

        return view('print.laporanpengirimanbeton', [
            'data' => $data,
            'tgl_awal' => $this->tgl_awal,
            'tgl_akhir' => $this->tgl_akhir
        ]);
    }
}
