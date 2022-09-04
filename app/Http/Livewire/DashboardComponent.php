<?php

namespace App\Http\Livewire;

use App\Models\Kendaraan;
use App\Models\VSalesOrder;
use App\Models\VTicket;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class DashboardComponent extends Component
{

    public function render()
    {
        return view('livewire.dashboard-component',[
            'totalpenjualan' => VTicket::where(DB::raw('month(jam_ticket)'), date('m'))->sum(DB::raw('jumlah*harga_intax')),
            'totalkubikasi' => VTicket::where(DB::raw('month(jam_ticket)'), date('m'))->sum(DB::raw('jumlah')),
            'totalticket' => VTicket::where(DB::raw('month(jam_ticket)'), date('m'))->count('*'),
            'sisaso' => VSalesOrder::where('status_detail','Open')->sum('sisa'),
            'jumlahso' => VSalesOrder::where('status_detail','Open')->count('*'),
            
        ]);
    }
}
