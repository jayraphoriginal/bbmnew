<?php

namespace App\Exports;

use App\Models\VTimesheetSewa;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class TimesheetExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */

    public $so_id ;

    public function __construct($so_id)
    {
        $this->so_id = $so_id;
    }

    public function view(): View
    {
        $data = VTimesheetSewa::where('m_salesorder_sewa_id',$this->so_id)->orderBy('tanggal','asc')->get();
        $tgl_awal = VTimesheetSewa::where('m_salesorder_sewa_id',$this->so_id)->orderBy('tanggal','asc')->first()->tanggal;
        $tgl_akhir = VTimesheetSewa::where('m_salesorder_sewa_id',$this->so_id)->orderBy('tanggal','desc')->first()->tanggal;
        return view('print.rekaptimesheet', [
            'data' => $data,
            'tgl_awal' => $tgl_awal,
            'tgl_akhir' => $tgl_akhir
        ]);
    }
}
