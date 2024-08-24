<?php

namespace App\Exports;

use App\Models\TmpKartuStok;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromView;

class KartuStokExportHarian implements FromView
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

        DB::statement("SET NOCOUNT ON; Exec SP_KartuStokHarian '".$this->tgl_awal."','".$this->tgl_akhir."',".$this->barang_id."");
        $data = TmpKartuStok::orderBy('tanggal','asc')->get();

        return view('print.laporankartustokharian', array(
            'data' => $data,
            'tgl_awal' => $this->tgl_awal,
            'tgl_akhir' => $this->tgl_akhir
        ));
    }
}
