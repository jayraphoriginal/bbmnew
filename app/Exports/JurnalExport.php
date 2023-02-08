<?php

namespace App\Exports;

use App\Models\VExportJurnal;
use App\Models\VJurnal;
use Maatwebsite\Excel\Concerns\FromCollection;

class JurnalExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    

    public function collection()
    {
       // $data = VExportJurnal::where('')
    }
}
