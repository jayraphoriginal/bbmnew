<?php

namespace App\Http\Livewire\Dashboard;

use App\Models\TmpPenjualanBulanan;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class PenjualanBulananChart extends Component
{
    public function render()
    {
        DB::update("Exec SP_PenjualanPerBulan ".date('Y').",' ".date("Y-m-d")."'");
        $penjualanbulan = TmpPenjualanBulanan::all()->pluck('jumlah','bulan');
       //return $penjualanbulan;
        $labels = $penjualanbulan->keys();
        $data = $penjualanbulan->values();

        return view('livewire.dashboard.penjualan-bulanan-chart',[
            'penjualanbulan' => $penjualanbulan,
            'labels' => $labels,
            'valuepenjualan' => $data,
        ]);
    }
}
