<?php

namespace App\Exports;

use App\Models\VKartuStok;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromView;

class KartuStokExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */

    public $tgl_awal, $tgl_akhir, $barang_id;
    public function __construct($tgl_awal, $tgl_akhir, $barang_id)
    {
        $this->tgl_awal = $tgl_awal;
        $this->tgl_akhir = $tgl_akhir;
        $this->barang_id = $barang_id;
    }

    public function view(): View
    {
        $user = Auth::user();
        if (!$user->hasPermissionTo('Laporan Kartu Stok')){
            return abort(401);
        }

        $data = VKartuStok::where('tanggal','>=',date_create($this->tgl_awal)->format(('d/M/Y')))
        ->where('tanggal','<=',date_create($this->tgl_akhir)->format(('d/M/Y')))
        ->where('barang_id',$this->barang_id)
        ->orderBy('tanggal','asc')
        ->orderBy(DB::raw('CASE WHEN increase > 0 THEN 0 ELSE 1 END'),'asc')
        ->orderBy('trans_id','asc')
        ->orderBy('id','asc')->get();

        return view('print.laporankartustok', array(
            'data' => $data,
            'tgl_awal' => $this->tgl_awal,
            'tgl_akhir' => $this->tgl_akhir
        ));
    }
}
