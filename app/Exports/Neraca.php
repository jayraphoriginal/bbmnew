<?php

namespace App\Exports;

use App\Models\Neraca as ModelsNeraca;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromView;

class Neraca implements FromView
{
    public $tanggal;
    public function __construct($tanggal)
    {
        $this->tanggal = $tanggal;
    }

    public function view(): View
    {
       
        DB::statement("SET NOCOUNT ON; Exec sp_neraca '".$this->tanggal."'");

        $data = ModelsNeraca::orderby('level1')->orderBy('level2')->get();

        return view('print.neraca', [
            'data' => $data,
            'tanggal' => $this->tanggal,
        ]);
    }
}
