<?php

namespace App\Http\Livewire\Dashboard;

use App\Models\VTicketHeader;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class PenjualanMutubetonChart extends Component
{
    public function render()
    {
        $datamutu = VTicketHeader::where(DB::raw('year(jam_ticket)'),date('Y'))
        ->select(DB::raw('sum(jumlah) as jumlah'),'kode_mutu')
        ->groupBy('kode_mutu')
        ->get()->pluck('jumlah','kode_mutu');

        $labels = $datamutu->keys();
        $data = $datamutu->values();

        return view('livewire.dashboard.penjualan-mutubeton-chart',[
            'penjualanbulan' => $datamutu,
            'labels' => $labels,
            'valuepenjualan' => $data,
        ]);
    }
}
