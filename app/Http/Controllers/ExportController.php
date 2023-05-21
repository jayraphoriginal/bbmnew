<?php

namespace App\Http\Controllers;

use App\Exports\JurnalExport;
use App\Exports\JurnalTanggalExport;
use App\Exports\PembelianExport;
use App\Exports\RekapInvoiceExport;
use App\Exports\RekapTicketExport;
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
    public function exportjurnalumum($tgl_awal,$tgl_akhir,$coa_id){
        return Excel::download(new JurnalExport($coa_id,$tgl_awal,$tgl_akhir), 'exportjurnal.xlsx');
    }
    public function exportpembelianbarang($tgl_awal,$tgl_akhir,$barang_id){
        return Excel::download(new PembelianExport($barang_id,$tgl_awal,$tgl_akhir), 'exportpembelian.xlsx');
    }
    public function exportrekapticket($tgl_awal,$tgl_akhir){
        return Excel::download(new RekapTicketExport($tgl_awal,$tgl_akhir), 'exportrekapticket.xlsx');
    }
    public function exportjurnaltanggal($tgl_awal,$tgl_akhir){
        return Excel::download(new JurnalTanggalExport($tgl_awal,$tgl_akhir), 'exportjurnal.xlsx');
    }

    
}
