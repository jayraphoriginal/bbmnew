<?php

namespace App\Http\Livewire;

use App\Models\Kendaraan;
use App\Models\TmpPenjualanBulanan;
use App\Models\VBerlakuKendaraan;
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
        ]);
    }
}
