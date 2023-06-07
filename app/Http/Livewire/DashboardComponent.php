<?php

namespace App\Http\Livewire;

use App\Models\Kendaraan;
use App\Models\TmpPenjualanBulanan;
use App\Models\VBerlakuKendaraan;
use App\Models\VJurnal;
use App\Models\VPembayaran;
use App\Models\VPenerimaan;
use App\Models\VSalesOrder;
use App\Models\VTicket;
use App\Models\VTicketHeader;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Asantibanez\LivewireCharts\Models\ColumnChartModel;

class DashboardComponent extends Component
{
    public $tgl_awal, $tgl_akhir;

    public function mount(){
        $this->tgl_awal = date('Y-m-01');
        $this->tgl_akhir = date('Y-m-d');
    }

    public function render()
    {
        return view('livewire.dashboard-component',[
            'totalpenjualan' => VTicketHeader::where(DB::raw('month(jam_ticket)'), date('m'))->where(DB::raw('year(jam_ticket)'), date('Y'))->sum(DB::raw('jumlah*harga_intax')),
            'totalkubikasi' => VTicketHeader::where(DB::raw('month(jam_ticket)'), date('m'))->where(DB::raw('year(jam_ticket)'), date('Y'))->sum(DB::raw('jumlah')),
            'totalticket' => VTicketHeader::where(DB::raw('month(jam_ticket)'), date('m'))->where(DB::raw('year(jam_ticket)'), date('Y'))->count('*'),
            'sisaso' => VSalesOrder::where('sisa','>',0)->sum('sisa'),
            'jumlahso' => VSalesOrder::where('sisa','>',0)->count('*'),
            'siu' => VBerlakuKendaraan::where('jt_siu','<=','30')->count('*'),
            'stnk' => VBerlakuKendaraan::where('jt_stnk','<=','30')->count('*'),
            'kir' => VBerlakuKendaraan::where('jt_kir','<=','30')->count('*'),
            'stokmaterial' => DB::table('V_StokMaterial')->whereraw('stok_minimum > stok')->count('*'),
            'hutang' => VJurnal::where(DB::raw('left(kode_akun,3)'), '210')->sum(DB::raw('kredit-debet')),
            'piutang' => VJurnal::where(DB::raw('left(kode_akun,3)'), '110')->sum(DB::raw('debet-kredit')),
            'warkatmasuk' => VPenerimaan::wherenull('tgl_cair')->where(
                function ($query){
                    $query->where('tipe','cheque')
                        ->orWhere('tipe','giro');
                })->count('*'),
            'warkatkeluar' => VPembayaran::wherenull('tgl_cair')->where(
                function ($query){
                    $query->where('tipe','cheque')
                        ->orWhere('tipe','giro');
                })->count('*'),
        ]);
    }
}
