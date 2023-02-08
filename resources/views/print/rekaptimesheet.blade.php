<html>

    <head>
        <title>Rekap Timesheet</title>
    </head>

    <style>
        .mytable>tbody>tr>td, .mytable>tbody>tr>th, .mytable>tfoot>tr>td, .mytable>tfoot>tr>th, .mytable>thead>tr>td, .mytable>thead>tr>th {
            padding: 5px;
            vertical-align: middle;
            border:1px solid;
            margin:0;
        }
        *{
            font-size:13px;
        }
        table{
            border-collapse: collapse;
        }
        @page{
            margin: 0.3in 0.3in 0.2in 0.3in;
        }
        body{
            margin:0;
        }
        .page_break { 
            page-break-before: always; 
        }
    </style>

    <body>
        

        @php
            $timesheets = $data->groupBy('nama_item');
            $timesheets->toArray();
            $jumlah = count($timesheets);
            $urut = 1;
        @endphp        
        
        @foreach ($timesheets as $timesheet => $times )
        <h3 style="margin-bottom: 3rem;text-align:center; font-size:18px">REKAP TIME SHEET</h3>
            <table style="margin-bottom: 3rem;width:100%">
                <tr>
                    <td style="width: 8rem;">Jenis alat</td>
                    <td> : </td>
                    <td>{{ $timesheet }}</td>
                </tr>
                <tr>
                    <td style="width: 2rem;">Pemakai</td>
                    <td> : </td>
                    <td>{{ $times[0]->nama_customer }}</td>
                </tr>
                <tr>
                    <td style="width: 2rem;">Periode</td>
                    <td> : </td>
                    <td>{{ date_create($tgl_awal)->format('d/m/Y').' - '.date_create($tgl_akhir)->format('d/m/Y') }}</td>
                </tr>
            </table>

            <table class="mytable" style="width:100%">
                <tr>
                    <td rowspan="2" class="tdhead">No</td>
                    <td rowspan="2" class="tdhead">Tanggal</td>
                    <td rowspan="2" class="tdhead">Operator</td>
                    <td colspan="2" class="tdhead" style="text-align:center">Waktu Operasi</td>
                    <td rowspan="2" class="tdhead" style="text-align:center">Istirahat</td>
                    <td rowspan="2" class="tdhead" style="text-align:center">Jumlah Waktu Operasi</td>
                    <td rowspan="2" class="tdhead">Keterangan</td>
                </tr>
                <tr>
                    <td style="text-align:center">Awal</td>
                    <td style="text-align:center">Akhir</td>
                </tr>
                @php
                    $jamtotal = 0;
                @endphp
            @foreach($times as $index => $time)
            <tr>
                <td>{{ ++$index }}</td>
                <td>{{ date_create($time->tanggal)->format('d/m/Y') }}</td>
                <td>{{ $time->nama_driver }}</td>
                @if($time->tipe == 'Jam')
                
                    <td style="text-align:center">{{ date_create($time->jam_awal)->format('H:i') }}</td>
                    <td style="text-align:center">{{ date_create($time->jam_akhir)->format('H:i') }}</td>
                    <td style="text-align:center">{{ $time->istirahat }}</td>
                @php
                   $menit = $time->lama%60 <> 0 ? $time->lama%60 . ' Menit' : '';
                @endphp
                    <td>{{ floor($time->lama/60). ' Jam '. $menit   }}</td>
                @else
                    <td>{{ $time->hm_awal }}</td>
                    <td>{{ $time->hm_akhir }}</td>
                    <td>{{ $time->istirahat }}</td>
                    <td>{{ $time->hm_akhir - $time->hm_awal - $time->istirahat }}</td>
                @endif
                <td>{{ $time->keterangan }}</td>
            </tr>
                @php
                    if($time->tipe == 'Jam'){
                        $jamtotal = $jamtotal + $time->lama;
                    }
                    else{
                        $jamtotal = $jamtotal + $time->hm_akhir - $time->hm_awal - $time->istirahat;
                    }
                @endphp
            @endforeach 
            <tr>
                @php
                   $menit = $jamtotal%60 <> 0 ? $jamtotal%60 . ' Menit' : '';
                @endphp
                <td colspan="6">
                    Jumlah Total
                </td>
                <td>{{ floor($jamtotal/60). ' Jam '. $menit }}</td>
                <td></td>
            </tr>
            </table>
            @if ($urut++ < $jumlah )
                <div class="page_break"></div>
            @endif
            
        @endforeach
    </body>

</html>