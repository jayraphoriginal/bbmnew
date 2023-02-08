<?php

namespace App\Http\Controllers;

use App\Exports\RekapInvoiceExport;
use App\Exports\TimesheetExport;
use App\Http\Livewire\Laporan\RekapInvoice;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    public function ExportTimesheet($so_id){
        return Excel::download(new TimesheetExport($so_id), 'timesheet.xlsx');
    }

    public function ExportRekapInvoice($tgl_awal,$tgl_akhir){
        return Excel::download(new RekapInvoiceExport('regular',$tgl_awal,$tgl_akhir), 'rekapinvoice.xlsx');
    }
    public function ExportRekapInvoiceRetail($tgl_awal,$tgl_akhir){
        return Excel::download(new RekapInvoiceExport('retail',$tgl_awal,$tgl_akhir), 'rekapinvoiceretail.xlsx');
    }
}
