<?php

namespace App\Http\Controllers;

use App\Exports\JurnalExport;
use App\Exports\JurnalPengeluaranBiaya;
use App\Exports\JurnalTanggalExport;
use App\Exports\Neraca;
use App\Exports\PembelianBiayaExport;
use App\Exports\PembelianExport;
use App\Exports\RekapBiaya;
use App\Exports\RekapHutang;
use App\Exports\RekapHutangPajak;
use App\Exports\RekapInvoiceExport;
use App\Exports\RekapPengeluaranBiaya;
use App\Exports\RekapPiutang;
use App\Exports\RekapPiutangKaryawan;
use App\Exports\RekapSaldoKasbank;
use App\Exports\RekapTicketExport;
use App\Exports\RekapUangmukaPajak;
use App\Exports\SaldoKasBank;
use App\Exports\TimesheetExport;
use App\Exports\TrialBalance;
use App\Exports\WarkatKeluar;
use App\Exports\WarkatMasuk;
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

    public function exportrekapsaldokasbank($tgl_awal,$tgl_akhir){
        $user = Auth::user();
        if (!$user->hasPermissionTo('Laporan Rekap Saldo Kas Bank')){
            return abort(401);
        }
        return Excel::download(new RekapSaldoKasbank($tgl_awal,$tgl_akhir), 'exportsaldorekening.xlsx');
    }
    
    public function exportrekappiutang($tgl_awal,$tgl_akhir){
        $user = Auth::user();
        if (!$user->hasPermissionTo('Laporan Rekap Piutang')){
            return abort(401);
        }
        return Excel::download(new RekapPiutang($tgl_awal,$tgl_akhir), 'exportrekappiutang.xlsx');
    }
    public function exportrekappiutangkaryawan($tgl_awal,$tgl_akhir){
        $user = Auth::user();
        if (!$user->hasPermissionTo('Laporan Rekap Piutang Karyawan')){
            return abort(401);
        }
        return Excel::download(new RekapPiutangKaryawan($tgl_awal,$tgl_akhir), 'exportrekappiutangkaryawan.xlsx');
    }

    public function exportrekaphutang($tgl_awal,$tgl_akhir){
        $user = Auth::user();
        if (!$user->hasPermissionTo('Laporan Rekap Hutang')){
            return abort(401);
        }
        return Excel::download(new RekapHutang($tgl_awal,$tgl_akhir), 'exportrekaphutang.xlsx');
    }

    public function exportrekapbiaya($tgl_awal,$tgl_akhir){
        $user = Auth::user();
        if (!$user->hasPermissionTo('Laporan Rekap Biaya')){
            return abort(401);
        }
        return Excel::download(new RekapBiaya($tgl_awal,$tgl_akhir), 'exportrekapbiaya.xlsx');
    }
    
    public function exportwarkatmasuk($tgl_awal,$tgl_akhir){
        $user = Auth::user();
        if (!$user->hasPermissionTo('Laporan Warkat Masuk')){
            return abort(401);
        }
        return Excel::download(new WarkatMasuk($tgl_awal,$tgl_akhir), 'exportwarkatmasuk.xlsx');
    }

    public function exportwarkatkeluar($tgl_awal,$tgl_akhir){
        $user = Auth::user();
        if (!$user->hasPermissionTo('Laporan Warkat Keluar')){
            return abort(401);
        }
        return Excel::download(new WarkatKeluar($tgl_awal,$tgl_akhir), 'exportwarkatmasuk.xlsx');
    }

    public function exportrekapuangmukapajak($tgl_awal,$tgl_akhir){
        $user = Auth::user();
        if (!$user->hasPermissionTo('Laporan Uang Muka Pajak')){
            return abort(401);
        }
        return Excel::download(new RekapUangmukaPajak($tgl_awal,$tgl_akhir), 'exportrekapuangmukapajak.xlsx');
    }

    public function exportrekaphutangpajak($tgl_awal,$tgl_akhir){
        $user = Auth::user();
        if (!$user->hasPermissionTo('Laporan Hutang Pajak')){
            return abort(401);
        }
        return Excel::download(new RekapHutangPajak($tgl_awal,$tgl_akhir), 'exportrekaphutangpajak.xlsx');
    }

    public function exporttrialbalance($tahun,$bulan){
        $user = Auth::user();
        if (!$user->hasPermissionTo('Laporan Trial Balance')){
            return abort(401);
        }
        return Excel::download(new TrialBalance($tahun,$bulan), 'exporttrialbalance.xlsx');
    }

    public function exportneraca($tanggal){
        $user = Auth::user();
        if (!$user->hasPermissionTo('Laporan Neraca')){
            return abort(401);
        }
        return Excel::download(new Neraca($tanggal), 'exportneraca.xlsx');
    }

    public function exportpembelianbiaya($tgl_awal,$tgl_akhir){
        $user = Auth::user();
        if (!$user->hasPermissionTo('Laporan Pembelian Biaya')){
            return abort(401);
        }
        return Excel::download(new PembelianBiayaExport($tgl_awal,$tgl_akhir), 'exportpembelianbiaya.xlsx');
    }

   
}
