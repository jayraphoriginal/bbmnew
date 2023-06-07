<?php

namespace App\Http\Controllers;

use App\Exports\JurnalExport;
use App\Exports\JurnalPengeluaranBiaya;
use App\Exports\JurnalTanggalExport;
use App\Exports\PembelianExport;
use App\Exports\RekapInvoiceExport;
use App\Exports\RekapPengeluaranBiaya;
use App\Exports\RekapTicketExport;
use App\Exports\SaldoKasBank;
use App\Exports\TimesheetExport;
use App\Http\Livewire\Laporan\RekapInvoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    public function ExportTimesheet($so_id){
        return Excel::download(new TimesheetExport($so_id), 'timesheet.xlsx');
    }

    public function ExportRekapInvoice($tgl_awal,$tgl_akhir){
        $user = Auth::user();
        if (!$user->hasPermissionTo('Rekap Invoice')){
            return abort(401);
        }
        return Excel::download(new RekapInvoiceExport('regular',$tgl_awal,$tgl_akhir), 'rekapinvoice.xlsx');
    }
    public function ExportRekapInvoiceRetail($tgl_awal,$tgl_akhir){
        $user = Auth::user();
        if (!$user->hasPermissionTo('Rekap Invoice')){
            return abort(401);
        }
        return Excel::download(new RekapInvoiceExport('retail',$tgl_awal,$tgl_akhir), 'rekapinvoiceretail.xlsx');
    }
    public function exportjurnalumum($tgl_awal,$tgl_akhir,$coa_id){
        $user = Auth::user();
        if (!$user->hasPermissionTo('Laporan Jurnal Umum')){
            return abort(401);
        }
        return Excel::download(new JurnalExport($coa_id,$tgl_awal,$tgl_akhir), 'exportjurnal.xlsx');
    }
    public function exportpembelianbarang($tgl_awal,$tgl_akhir,$barang_id){
        $user = Auth::user();
        if (!$user->hasPermissionTo('Laporan Pembelian Barang')){
            return abort(401);
        }
        return Excel::download(new PembelianExport($barang_id,$tgl_awal,$tgl_akhir), 'exportpembelian.xlsx');
    }
    public function exportrekapticket($tgl_awal,$tgl_akhir){
        $user = Auth::user();
        if (!$user->hasPermissionTo('Ticket')){
            return abort(401);
        }
        return Excel::download(new RekapTicketExport($tgl_awal,$tgl_akhir), 'exportrekapticket.xlsx');
    }
    public function exportjurnaltanggal($tgl_awal,$tgl_akhir){
        $user = Auth::user();
        if (!$user->hasPermissionTo('Laporan Jurnal per Tanggal')){
            return abort(401);
        }
        return Excel::download(new JurnalTanggalExport($tgl_awal,$tgl_akhir), 'exportjurnal.xlsx');
    }
    public function exportrekappengeluaranbiaya($tgl_awal,$tgl_akhir){
        $user = Auth::user();
        if (!$user->hasPermissionTo('Rekap Pengeluaran Biaya')){
            return abort(401);
        }
        return Excel::download(new RekapPengeluaranBiaya($tgl_awal,$tgl_akhir), 'exportpengeluaranbiaya.xlsx');
    }

    public function exportjurnalpengeluaranbiaya($tgl_awal,$tgl_akhir){
        $user = Auth::user();
        if (!$user->hasPermissionTo('Laporan Jurnal Pengeluaran Biaya')){
            return abort(401);
        }
        return Excel::download(new JurnalPengeluaranBiaya($tgl_awal,$tgl_akhir), 'exportpengeluaranbiaya.xlsx');
    }

    public function exportsaldorekening($tgl_awal,$tgl_akhir,$rekening_id){
        $user = Auth::user();
        if (!$user->hasPermissionTo('Laporan Saldo Rekening')){
            return abort(401);
        }
        return Excel::download(new SaldoKasBank($tgl_awal,$tgl_akhir,$rekening_id), 'exportsaldorekening.xlsx');
    }
    
}
