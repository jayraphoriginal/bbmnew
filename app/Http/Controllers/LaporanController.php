<?php

namespace App\Http\Controllers;

use App\Models\BahanBakar;
use App\Models\Customer;
use App\Models\Driver;
use App\Models\GajiRate;
use App\Models\Kendaraan;
use App\Models\MSalesorder;
use App\Models\PemakaianBbm;
use App\Models\PengisianBbm;
use App\Models\PengisianBbmStok;
use App\Models\Rate;
use App\Models\Rekening;
use App\Models\Supplier;
use App\Models\TambahanBbm;
use App\Models\TmpGajiDriver;
use App\Models\TmpPenjualanBulanan;
use App\Models\TmpReportTicket;
use App\Models\VConcretepump;
use App\Models\VHutang;
use App\Models\VInvoiceHeader;
use App\Models\VJurnal;
use App\Models\VPembayaran;
use App\Models\VPembelianDetail;
use App\Models\VPengeluaranBiayaDetail;
use App\Models\VPengisianBbm;
use App\Models\VSaldoRekening;
use App\Models\VTicketHeader;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PDF;
use Riskihajar\Terbilang\Facades\Terbilang;

class LaporanController extends Controller
{
    
    public function gaji($tgl_awal,$tgl_akhir){

        $user = Auth::user();
        if (!$user->hasPermissionTo('Laporan Gaji Driver')){
            return abort(401);
        }

        DB::table('tmp_gaji_drivers')->delete();

        $drivers = Driver::all();

       // return print_r($drivers);

        foreach($drivers as $driver ){

            $kendaraan = Kendaraan::where('driver_id',$driver->id)->first();

            if (!is_null($kendaraan)){

                $tickets = VTicketHeader::select('driver_id', 'jam_ticket',
                'loading', 'lembur', 'so_id',
                'kendaraan_id','rate_id')
                ->where(DB::raw('convert(date,jam_ticket)'),'>=',$tgl_awal)
                ->where(DB::raw('convert(date,jam_ticket)'),'<=',$tgl_akhir)
                ->where(
                    function ($query) use ($kendaraan,$driver) {
                        $query->where('kendaraan_id',$kendaraan->id)
                            ->orWhere('driver_id',$driver->id);
                    })
                ->get();

                foreach($tickets as $ticket){

                    $rate = Rate::find($ticket->rate_id);
                    $pemakaianbbms = PemakaianBbm::where('muatan',$kendaraan->muatan)->first();

                    if($ticket->kendaraan_id == $kendaraan->id){
                        $pemakaianbbm = $pemakaianbbms->pemakaian * $rate->estimasi_jarak;
                        $loading = $ticket->loading;
                    }
                    else{
                        $pemakaianbbm = 0;
                        $loading = 0;
                    }

                    $msalesorder = MSalesorder::find($ticket->so_id);
                    $customer = Customer::find($msalesorder->customer_id);

                    $kendaraanticket = Kendaraan::find($ticket->kendaraan_id);


                    if($ticket->driver_id==$driver->id){
                        $gajis = GajiRate::where('muatan',$kendaraanticket->muatan)
                                        ->where('batas_bawah_jarak','<=',$rate->estimasi_jarak)
                                        ->where('batas_atas_jarak','>=',$rate->estimasi_jarak)
                                        ->first();
                      //  return $rate->estimasi_jarak;
                        if (is_null($gajis)){
                            return $rate->estimasi_jarak;
                        }
                        else{
                            $gaji = $gajis->gaji;
                        }
                    }
                    else
                    {
                        $gaji = 0;
                    }

                    $tmp = new TmpGajiDriver();
                    $tmp['tanggal_awal'] = $tgl_awal;
                    $tmp['tanggal_akhir'] = $tgl_akhir;
                    $tmp['periode'] = date_diff(date_create($tgl_awal),date_create($tgl_akhir))->format("%a");
                    $tmp['nopol'] = $kendaraanticket->nopol;
                    $tmp['nama_driver'] = $driver->nama_driver;
                    $tmp['tanggal_ticket'] = date_format(date_create($ticket->jam_ticket),'Y-m-d');
                    $tmp['nama_customer'] = $customer->nama_customer;
                    $tmp['lokasi'] = $rate->tujuan;
                    $tmp['jarak'] = $rate->estimasi_jarak;
                    $tmp['pemakaian_bbm'] = $pemakaianbbm;
                    $tmp['lembur'] = $ticket->lembur;
                    $tmp['gaji'] = $gaji;
                    $tmp['pengisian_bbm'] =0;
                    $tmp['loading'] = $loading;
                    $tmp->save();

                }

                $pengisianbbms = PengisianBbm::where('kendaraan_id', $kendaraan->id)
                                ->where(DB::raw('convert(date,tanggal_pengisian)'),'>=',$tgl_awal)
                                ->where(DB::raw('convert(date,tanggal_pengisian)'),'<=',$tgl_akhir)
                                ->get();

                foreach($pengisianbbms as $pengisianbbm){

                    $tmp = new TmpGajiDriver();
                    $tmp['tanggal_awal'] = $tgl_awal;
                    $tmp['tanggal_akhir'] = $tgl_akhir;
                    $tmp['periode'] = date_diff(date_create($tgl_awal),date_create($tgl_akhir))->format("%a");
                    $tmp['nopol'] = $kendaraan->nopol;
                    $tmp['nama_driver'] = $driver->nama_driver;
                    $tmp['tanggal_ticket'] = date_format(date_create($pengisianbbm->tanggal_pengisian),'Y-m-d');
                    $tmp['nama_customer'] = 'Isi BBM';
                    $tmp['lokasi'] = 'Isi BBM';
                    $tmp['jarak'] = 0;
                    $tmp['pemakaian_bbm'] = 0;
                    $tmp['lembur'] = 0;
                    $tmp['gaji'] = 0;
                    $tmp['pengisian_bbm'] = $pengisianbbm->jumlah;
                    $tmp['loading'] = 0;
                    $tmp->save();

                }

                $tambahanbbms = TambahanBbm::where('kendaraan_id', $kendaraan->id)
                                ->where(DB::raw('convert(date,tanggal_penambahan)'),'>=',$tgl_awal)
                                ->where(DB::raw('convert(date,tanggal_penambahan)'),'<=',$tgl_akhir)
                                ->get();

                foreach($tambahanbbms as $tambahanbbm){

                    $tmp = new TmpGajiDriver();
                    $tmp['tanggal_awal'] = $tgl_awal;
                    $tmp['tanggal_akhir'] = $tgl_akhir;
                    $tmp['periode'] = date_diff(date_create($tgl_awal),date_create($tgl_akhir))->format("%a");
                    $tmp['nopol'] = $kendaraan->nopol;
                    $tmp['nama_driver'] = $driver->nama_driver;
                    $tmp['tanggal_ticket'] = date_format(date_create($pengisianbbm->tanggal_penambahan),'Y-m-d');
                    $tmp['nama_customer'] = $tambahanbbm->keterangan;
                    $tmp['lokasi'] = '-';
                    $tmp['jarak'] = 0;
                    $tmp['pemakaian_bbm'] = $tambahanbbm->jumlah;
                    $tmp['lembur'] = 0;
                    $tmp['gaji'] = 0;
                    $tmp['pengisian_bbm'] = 0;
                    $tmp['loading'] = 0;
                    $tmp->save();
                }
            }
        }

        $data = TmpGajiDriver::select('nama_driver',DB::raw('sum(loading) as loading'),'nopol','tanggal_ticket','nama_customer','lokasi','jarak','pemakaian_bbm',
        DB::raw('count(*) as rate'),DB::raw('sum(pemakaian_bbm) as total_liter'),
        DB::raw('sum(lembur) as lembur'),'gaji',DB::raw('sum(gaji) as total_gaji'),'pengisian_bbm')
        ->orderBy('nama_driver','asc')->orderBy('tanggal_ticket','asc')
        ->groupby('nama_driver','nopol','tanggal_ticket','nama_customer','lokasi','jarak','pemakaian_bbm','gaji','pengisian_bbm')
        ->get();
        $bbm = BahanBakar::orderby('id', 'desc')->first();

        // return $data;

        $pdf = PDF::loadView('print.gajidriver', array(
            'data' => $data,
            'bbm' => $bbm
        ));
        return $pdf->setPaper('A4','Landscape')->stream();

    }

    public function rekapticket($soid){

        $user = Auth::user();
        if (!$user->hasPermissionTo('Ticket')){
            return abort(401);
        }
        
        $data = VTicketHeader::where('so_id',$soid)
        ->orderBy('V_TicketHeader.jam_ticket')
        ->get();

        $pdf = PDF::loadView('print.rekapticketmaterial', array(
            'data' => $data,
        ));
        return $pdf->setPaper('A4','potrait')->stream();
    }

    public function rekaptickettanggal($tgl_awal,$tgl_akhir){

        $user = Auth::user();
        if (!$user->hasPermissionTo('Laporan Rekap Ticket')){
            return abort(401);
        }
        
        DB::update("Exec SP_ReportTicketTanggal '".$tgl_awal."','".$tgl_akhir."'");
        $data = TmpReportTicket::all();

        // $data = VTicketHeader::where(DB::raw('convert(date,jam_ticket)'),'>=',$tgl_awal)
        // ->where(DB::raw('convert(date,jam_ticket)'),'<=',$tgl_akhir)
        // ->orderBy('V_TicketHeader.jam_ticket')
        // ->get();

        $pdf = PDF::loadView('print.rekaptickettanggal', array(
            'data' => $data,
            'tgl_awal' => $tgl_awal,
            'tgl_akhir' => $tgl_akhir
        ));
        return $pdf->setPaper('A4','landscape')->stream();
    }

    public function penjualanbeton($tgl_awal,$tgl_akhir){

        $user = Auth::user();
        if (!$user->hasPermissionTo('Laporan Penjualan Beton')){
            return abort(401);
        }
        
        DB::update("Exec SP_ReportTicketTanggal '".$tgl_awal."','".$tgl_akhir."'");
        $data = TmpReportTicket::all();

        $datacustomer = TmpReportTicket::select('nama_customer','kode_mutu','tujuan','satuan',DB::raw('sum(jumlah) as total'))
        ->groupBy('nama_customer','kode_mutu','tujuan','satuan')->get();

        DB::update("Exec SP_PenjualanPerBulan ".date('Y'));
        $penjualanbulan = TmpPenjualanBulanan::all();
       // return $penjualanbulan;

        $pdf = PDF::loadView('print.rekappenjualanbeton', array(
            'data' => $data,
            'datacustomer' => $datacustomer,
            'penjualanbulanan' => $penjualanbulan,
            'tgl_awal' => $tgl_awal,
            'tgl_akhir' => $tgl_akhir
        ));
        return $pdf->setPaper('A4','potrait')->stream();
    }

    public function penjualanbetoncustomer($tgl_awal,$tgl_akhir){

        $user = Auth::user();
        if (!$user->hasPermissionTo('Laporan Penjualan Beton Per Customer')){
            return abort(401);
        }
        
        DB::update("Exec SP_ReportTicketTanggal '".$tgl_awal."','".$tgl_akhir."'");

        $datacustomer = TmpReportTicket::select('nama_customer','kode_mutu',DB::raw('harga_intax / (1+(pajak/100)) as harga'),'tujuan','satuan',DB::raw('sum(jumlah) as total'))
        ->groupBy('nama_customer',DB::raw('harga_intax / (1+(pajak/100))'),'kode_mutu','tujuan','satuan')->get();

        $pdf = PDF::loadView('print.rekappenjualanbetoncustomer', array(
            'datacustomer' => $datacustomer,
            'tgl_awal' => $tgl_awal,
            'tgl_akhir' => $tgl_akhir
        ));
        return $pdf->setPaper('A4','potrait')->stream();
    }

    public function rekapconcretepump($soid){

        $user = Auth::user();
        if (!$user->hasPermissionTo('Concrete Pump')){
            return abort(401);
        }
        
        $data = VConcretepump::where('m_salesorder_id',$soid)
        ->get();

        $pdf = PDF::loadView('print.rekapconcretepump', array(
            'data' => $data,
        ));
        return $pdf->setPaper('A4','potrait')->stream();
    }

    public function rekaphutang($tgl_awal,$tgl_akhir){
        
        $data = VHutang::select('V_Hutang.nama_supplier', DB::raw('0 as saldo_awal'), DB::raw('sum(V_Hutang.debet) as debet'), DB::raw('sum(V_Hutang.kredit) as kredit'))
        ->where(DB::raw('convert(date,tanggal_transaksi)'),'>=',$tgl_awal)
        ->where(DB::raw('convert(date,tanggal_transaksi)'),'<=',$tgl_akhir)
        ->orderBy('V_Hutang.tanggal_transaksi')
        ->groupBy('V_Hutang.tanggal_transaksi')
        ->get();

        $pdf = PDF::loadView('print.rekaphutang', array(
            'data' => $data,
            'tgl_awal' => $tgl_awal,
            'tgl_akhir' => $tgl_akhir
        ));
        return $pdf->setPaper('A4','potrait')->stream();
    }

    public function penjualanmutubeton($tgl_awal,$tgl_akhir){

        $user = Auth::user();
        if (!$user->hasPermissionTo('Laporan Penjualan per Mutubeton')){
            return abort(401);
        }
        
        $data = VTicketHeader::where(DB::raw('convert(date,jam_ticket)'),'>=',$tgl_awal)
        ->where(DB::raw('convert(date,jam_ticket)'),'<=',$tgl_akhir)
        ->select('kode_mutu', 'deskripsi' ,DB::raw('sum(jumlah) as jumlah'), DB::raw('sum(jumlah*harga_intax) as total'))
        ->groupBy('kode_mutu', 'deskripsi')
        ->get();

        $pdf = PDF::loadView('print.penjualanmutubeton', array(
            'data' => $data,
            'tgl_awal' => $tgl_awal,
            'tgl_akhir' => $tgl_akhir
        ));
        return $pdf->setPaper('A4','portrait')->stream();
    }

    public function gajidriver($tgl_awal,$tgl_akhir,$driver_id){

        $user = Auth::user();
        if (!$user->hasPermissionTo('Laporan Gaji per Driver')){
            return abort(401);
        }

        DB::table('tmp_gaji_drivers')->delete();

        $driver = Driver::find($driver_id);

        $kendaraan = Kendaraan::where('driver_id',$driver->id)->first();

        if (!is_null($kendaraan)){

            $tickets = VTicketHeader::select('driver_id', 'jam_ticket',
            'loading', 'lembur', 'so_id',
            'kendaraan_id','rate_id')
            ->where(DB::raw('convert(date,jam_ticket)'),'>=',$tgl_awal)
            ->where(DB::raw('convert(date,jam_ticket)'),'<=',$tgl_akhir)
            ->where(
                function ($query) use ($kendaraan,$driver) {
                    $query->where('kendaraan_id',$kendaraan->id)
                        ->orWhere('driver_id',$driver->id);
                })
            ->get();

            foreach($tickets as $ticket){

                $rate = Rate::find($ticket->rate_id);
                $pemakaianbbms = PemakaianBbm::where('muatan',$kendaraan->muatan)->first();

                if($ticket->kendaraan_id == $kendaraan->id){
                    $pemakaianbbm = $pemakaianbbms->pemakaian * $rate->estimasi_jarak;
                    $loading = $ticket->loading;
                }
                else{
                    $pemakaianbbm = 0;
                    $loading = 0;
                }

                $msalesorder = MSalesorder::find($ticket->so_id);
                $customer = Customer::find($msalesorder->customer_id);

                $kendaraanticket = Kendaraan::find($ticket->kendaraan_id);

                if($ticket->driver_id==$driver->id){
                    $gajis = GajiRate::where('muatan',$kendaraanticket->muatan)
                                    ->where('batas_bawah_jarak','<=',$rate->estimasi_jarak)
                                    ->where('batas_atas_jarak','>=',$rate->estimasi_jarak)
                                    ->first();
                    //  return $rate->estimasi_jarak;
                    if (is_null($gajis)){
                        return $rate->estimasi_jarak;
                    }
                    else{
                        $gaji = $gajis->gaji;
                    }
                }
                else
                {
                    $gaji = 0;
                }

                $tmp = new TmpGajiDriver();
                $tmp['tanggal_awal'] = $tgl_awal;
                $tmp['tanggal_akhir'] = $tgl_akhir;
                $tmp['periode'] = date_diff(date_create($tgl_awal),date_create($tgl_akhir))->format("%a");
                $tmp['nopol'] = $kendaraanticket->nopol;
                $tmp['nama_driver'] = $driver->nama_driver;
                $tmp['tanggal_ticket'] = date_format(date_create($ticket->jam_ticket),'Y-m-d');
                $tmp['nama_customer'] = $customer->nama_customer;
                $tmp['lokasi'] = $rate->tujuan;
                $tmp['jarak'] = $rate->estimasi_jarak;
                $tmp['pemakaian_bbm'] = $pemakaianbbm;
                $tmp['lembur'] = $ticket->lembur;
                $tmp['gaji'] = $gaji;
                $tmp['pengisian_bbm'] =0;
                $tmp['loading'] = $loading;
                $tmp->save();

            }

            $pengisianbbms = PengisianBbm::where('kendaraan_id', $kendaraan->id)
                            ->where(DB::raw('convert(date,tanggal_pengisian)'),'>=',$tgl_awal)
                            ->where(DB::raw('convert(date,tanggal_pengisian)'),'<=',$tgl_akhir)
                            ->get();

            foreach($pengisianbbms as $pengisianbbm){

                $tmp = new TmpGajiDriver();
                $tmp['tanggal_awal'] = $tgl_awal;
                $tmp['tanggal_akhir'] = $tgl_akhir;
                $tmp['periode'] = date_diff(date_create($tgl_awal),date_create($tgl_akhir))->format("%a");
                $tmp['nopol'] = $kendaraan->nopol;
                $tmp['nama_driver'] = $driver->nama_driver;
                $tmp['tanggal_ticket'] = date_format(date_create($pengisianbbm->tanggal_pengisian),'Y-m-d');
                $tmp['nama_customer'] = 'Isi BBM';
                $tmp['lokasi'] = 'Isi BBM';
                $tmp['jarak'] = 0;
                $tmp['pemakaian_bbm'] = 0;
                $tmp['lembur'] = 0;
                $tmp['gaji'] = 0;
                $tmp['pengisian_bbm'] = $pengisianbbm->jumlah;
                $tmp['loading'] = 0;
                $tmp->save();

            }

            $pengisianbbmstoks = PengisianBbmStok::where('beban_id', $kendaraan->id)
                            ->where(DB::raw('convert(date,tgl_pengisian)'),'>=',$tgl_awal)
                            ->where(DB::raw('convert(date,tgl_pengisian)'),'<=',$tgl_akhir)
                            ->get();

            foreach($pengisianbbmstoks as $pengisianbbmstok){

                $tmp = new TmpGajiDriver();
                $tmp['tanggal_awal'] = $tgl_awal;
                $tmp['tanggal_akhir'] = $tgl_akhir;
                $tmp['periode'] = date_diff(date_create($tgl_awal),date_create($tgl_akhir))->format("%a");
                $tmp['nopol'] = $kendaraan->nopol;
                $tmp['nama_driver'] = $driver->nama_driver;
                $tmp['tanggal_ticket'] = date_format(date_create($pengisianbbmstok->tgl_pengisian),'Y-m-d');
                $tmp['nama_customer'] = 'Isi BBM dari Stok';
                $tmp['lokasi'] = 'Isi BBM dari Stok';
                $tmp['jarak'] = 0;
                $tmp['pemakaian_bbm'] = 0;
                $tmp['lembur'] = 0;
                $tmp['gaji'] = 0;
                $tmp['pengisian_bbm'] = $pengisianbbmstok->jumlah;
                $tmp['loading'] = 0;
                $tmp->save();

            }

            $tambahanbbms = TambahanBbm::where('kendaraan_id', $kendaraan->id)
                            ->where(DB::raw('convert(date,tanggal_penambahan)'),'>=',$tgl_awal)
                            ->where(DB::raw('convert(date,tanggal_penambahan)'),'<=',$tgl_akhir)
                            ->get();

            foreach($tambahanbbms as $tambahanbbm){

                $tmp = new TmpGajiDriver();
                $tmp['tanggal_awal'] = $tgl_awal;
                $tmp['tanggal_akhir'] = $tgl_akhir;
                $tmp['periode'] = date_diff(date_create($tgl_awal),date_create($tgl_akhir))->format("%a");
                $tmp['nopol'] = $kendaraan->nopol;
                $tmp['nama_driver'] = $driver->nama_driver;
                $tmp['tanggal_ticket'] = date_format(date_create($tambahanbbm->tanggal_penambahan),'Y-m-d');
                $tmp['nama_customer'] = $tambahanbbm->keterangan;
                $tmp['lokasi'] = '-';
                $tmp['jarak'] = 0;
                $tmp['pemakaian_bbm'] = $tambahanbbm->jumlah;
                $tmp['lembur'] = 0;
                $tmp['gaji'] = 0;
                $tmp['pengisian_bbm'] = 0;
                $tmp['loading'] = 0;
                $tmp->save();
            }
        }
        $data = TmpGajiDriver::select('nama_driver',DB::raw('sum(loading) as loading'),'nopol','tanggal_ticket','nama_customer','lokasi','jarak','pemakaian_bbm',
        DB::raw('count(*) as rate'),DB::raw('sum(pemakaian_bbm) as total_liter'),
        DB::raw('sum(lembur) as lembur'),'gaji',DB::raw('sum(gaji) as total_gaji'),'pengisian_bbm')
        ->orderBy('nopol','asc')
        ->orderBy('tanggal_ticket','asc')
        ->groupby('nama_driver','nopol','tanggal_ticket','nama_customer','lokasi','jarak','pemakaian_bbm','gaji','pengisian_bbm')
        ->get();
        $bbm = BahanBakar::orderby('id', 'desc')->first();

        $pdf = PDF::loadView('print.gajiperdriver', array(
            'data' => $data,
            'bbm' => $bbm
        ));
        return $pdf->setPaper('A4','Landscape')->stream();

    }

    public function bukubesarhutang($id_supplier,$tgl_awal,$tgl_akhir){
        
        $data = VPembelianDetail::select('V_PembelianDetail.tgl_masuk','V_PembelianDetail.jenis_beban','V_PembelianDetail.alken', 'V_PembelianDetail.nama_barang',DB::raw('(V_PembelianDetail.jumlah*V_PembelianDetail.harga) as kredit'))
        ->where('supplier_id',$id_supplier)
        ->where(DB::raw('convert(date,tgl_masuk)'),'>=',$tgl_awal)
        ->where(DB::raw('convert(date,tgl_masuk)'),'<=',$tgl_akhir)
        ->orderBy('V_PembelianDetail.tgl_masuk')
        ->get();

        $pdf = PDF::loadView('print.bukubesarhutang', array(
            'data' => $data,
            'tgl_awal' => $tgl_awal,
            'tgl_akhir' => $tgl_akhir
        ));
        return $pdf->setPaper('A4','potrait')->stream();
    }   

    public function laporanpembelian($tgl_awal,$tgl_akhir){

        $user = Auth::user();
        if (!$user->hasPermissionTo('Laporan Pembelian')){
            return abort(401);
        }

        $data = VPembelianDetail::where(DB::raw('convert(date,tgl_masuk)'),'>=',$tgl_awal)
        ->where(DB::raw('convert(date,tgl_masuk)'),'<=',$tgl_akhir)
        ->orderBy('V_PembelianDetail.tgl_masuk')
        ->get();

        $pdf = PDF::loadView('print.laporanpembelian', array(
            'data' => $data,
            'tgl_awal' => $tgl_awal,
            'tgl_akhir' => $tgl_akhir
        ));

        return $pdf->setPaper('A4','landscape')->stream();
    }

    public function laporanpembeliansupplier($tgl_awal,$tgl_akhir,$id_supplier){

        $user = Auth::user();
        if (!$user->hasPermissionTo('Laporan Pembelian per Supplier')){
            return abort(401);
        }

        $supplier = Supplier::find($id_supplier);

        $data = VPembelianDetail::where('supplier_id', $id_supplier)
        ->where(DB::raw('convert(date,tgl_masuk)'),'>=',$tgl_awal)
        ->where(DB::raw('convert(date,tgl_masuk)'),'<=',$tgl_akhir)
        ->orderBy('V_PembelianDetail.tgl_masuk')
        ->get();

        $pdf = PDF::loadView('print.laporanpembeliansupplier', array(
            'data' => $data,
            'supplier' => $supplier->nama_supplier,
            'tgl_awal' => $tgl_awal,
            'tgl_akhir' => $tgl_akhir
        ));

        return $pdf->setPaper('A4','landscape')->stream();
    }

    public function laporanpengisianbbm($tgl_awal,$tgl_akhir){

        $user = Auth::user();
        if (!$user->hasPermissionTo('Laporan Pengisian BBM')){
            return abort(401);
        }

        $data = VPengisianBbm::where('tanggal_pengisian','>=',$tgl_awal)
        ->where('tanggal_pengisian','<=',$tgl_akhir)
        ->orderBy('V_PengisianBbm.tanggal_pengisian')
        ->get();

        $pdf = PDF::loadView('print.laporanpengisianbbm', array(
            'data' => $data,
            'tgl_awal' => $tgl_awal,
            'tgl_akhir' => $tgl_akhir
        ));

        return $pdf->setPaper('A4','potrait')->stream();
    }

    public function laporankomposisi(){
        DB::update('exec SP_pivotkomposisi');

        $data = DB::table('tmppivot')->get();

        return $data;

        $pdf = PDF::loadView('print.laporankomposisi', array(
            'data' => $data,
        ));

        return $pdf->setPaper('A4','potrait')->stream();
    }

    public function rekapinvoice($tgl_awal,$tgl_akhir){

        $user = Auth::user();
        if (!$user->hasPermissionTo('Rekap Invoice')){
            return abort(401);
        }

        $data = VInvoiceHeader::where('tgl_cetak','>=',$tgl_awal)
        ->where('tgl_cetak','<=',$tgl_akhir)->get();

        $pdf = PDF::loadView('print.rekapinvoice', array(
            'data' => $data,
            'tgl_awal' => $tgl_awal,
            'tgl_akhir' => $tgl_akhir
        ));

        return $pdf->setPaper('A4','potrait')->stream();
    }

    public function rekappengeluaranbiaya($tgl_awal,$tgl_akhir){
        $data = VPengeluaranBiayaDetail::where('tgl_biaya','>=',$tgl_awal)
        ->where('tgl_biaya','<=',$tgl_akhir)->get();

        $pdf = PDF::loadView('print.rekappengeluaranbiaya', array(
            'data' => $data,
            'tgl_awal' => $tgl_awal,
            'tgl_akhir' => $tgl_akhir
        ));

        return $pdf->setPaper('A4','landscape')->stream();
    }

    public function laporanpenjualanpermobil($tgl_awal,$tgl_akhir,$kendaraan_id){
        $user = Auth::user();

        if (!$user->hasPermissionTo('Laporan Penjualan Beton per Mobil')){
            return abort(401);
        }
        
        DB::update("Exec SP_ReportTicketTanggal '".$tgl_awal."','".$tgl_akhir."'");
        $data = TmpReportTicket::where('kendaraan_id',$kendaraan_id)->orderBy('jam_ticket')->get();

        $pdf = PDF::loadView('print.rekappenjualanbetonpermobil', array(
            'data' => $data,
            'tgl_awal' => $tgl_awal,
            'tgl_akhir' => $tgl_akhir
        ));
        return $pdf->setPaper('A4','landscape')->stream();
    }

    public function laporanrekapconcretepump($tgl_awal,$tgl_akhir){

        $user = Auth::user();
        if (!$user->hasPermissionTo('Laporan Rekap Concretepump')){
            return abort(401);
        }
        
        $data = VConcretepump::where('tanggal','>=',$tgl_awal)
        ->where('tanggal','<=',$tgl_akhir)->get();

        $pdf = PDF::loadView('print.rekapconcretepump', array(
            'data' => $data,
            'tgl_awal' => $tgl_awal,
            'tgl_akhir' => $tgl_akhir
        ));
        return $pdf->setPaper('A4','potrait')->stream();
    }

    public function laporanjurnalpengeluaranbiaya($tgl_awal,$tgl_akhir){

        $user = Auth::user();
        if (!$user->hasPermissionTo('Laporan Jurnal Pengeluaran Biaya')){
            return abort(401);
        }
        
        $data = VJurnal::where('tipe','Pengeluaran Biaya')->where('tanggal_transaksi','>=',$tgl_awal)
        ->where('tanggal_transaksi','<=',$tgl_akhir)->get();

        $pdf = PDF::loadView('print.laporanjurnalpengeluaranbiaya', array(
            'data' => $data,
            'tgl_awal' => $tgl_awal,
            'tgl_akhir' => $tgl_akhir
        ));
        return $pdf->setPaper('A4','potrait')->stream();
    }

    public function laporansaldorekening($tgl_awal,$tgl_akhir,$rekening_id){
        $user = Auth::user();
        if (!$user->hasPermissionTo('Laporan Saldo Rekening')){
            return abort(401);
        }

        $rekening = Rekening::join('banks','rekenings.bank_id','banks.id')
        ->where('rekenings.id',$rekening_id)->get();
        
        DB::update("Exec SP_SaldoKasBank '".$tgl_awal."','".$tgl_akhir."',".$rekening_id."");
        $data = VSaldoRekening::where('tanggal','>=',$tgl_awal)
        ->where('tanggal','<=',$tgl_akhir)
        ->where('tipe','<>','Saldo Awal')
        ->orderBy('tanggal')->get();

        $pdf = PDF::loadView('print.laporansaldorekening', array(
            'data' => $data,
            'rekening' => $rekening,
            'tgl_awal' => $tgl_awal,
            'tgl_akhir' => $tgl_akhir
        ));
        return $pdf->setPaper('A4','potrait')->stream();
    }
}