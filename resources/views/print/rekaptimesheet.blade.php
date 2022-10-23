<html>

    <head>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <title>Rekap Timesheet</title>
    </head>

    <style>
        .mytable>tbody>tr>td, .mytable>tbody>tr>th, .mytable>tfoot>tr>td, .mytable>tfoot>tr>th, .mytable>thead>tr>td, .mytable>thead>tr>th {
            padding: 5px;
            vertical-align: middle;
        }
        *{
            font-size:13px;
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
            $timesheets = $data->groupBy('nama_alat');
            $timesheets->toArray();
            $jumlah = count($timesheets);
            $urut = 1;
        @endphp        
        
        @foreach ($timesheets as $timesheet => $times )
        <h3 style="margin-bottom: 3rem;text-align:center">REKAP TIME SHEET</h3>
            <table style="margin-bottom: 3rem;">
                <tr>
                    <td style="width: 2rem;">Jenis alat</td>
                    <td> : </td>
                    <td>{{ $timesheet }}</td>
                </tr>
                <tr>
                    <td style="width: 2rem;">Pemakai</td>
                    <td> : </td>
                    <td>{{ $times[0]->nama_customer }}</td>
                </tr>
            </table>

            <table class="table table-striped table-bordered mytable">
                <tr>
                    <td rowspan="2" class="tdhead">No</td>
                    <td rowspan="2" class="tdhead">Tanggal</td>
                    <td rowspan="2" class="tdhead">Operator</td>
                    <td colspan="2" class="tdhead">Waktu Operasi</td>
                    <td rowspan="2" class="tdhead">Istirahat</td>
                    <td rowspan="2" class="tdhead">Jumlah Waktu Operasi</td>
                    <td rowspan="2" class="tdhead">Keterangan</td>
                </tr>
                <tr>
                    <td>Awal</td>
                    <td>Akhir</td>
                </tr>
                @php
                    $jamtotal = 0;
                @endphp
            @foreach($times as $index => $time)
            <tr>
                <td>{{ ++$index }}</td>
                <td>{{ $time->tanggal }}</td>
                <td>{{ $time->operator }}</td>
                @if($time->tipe == 'jam')
                    <td>{{ $time->jam_awal }}</td>
                    <td>{{ $time->jam_akhir }}</td>
                    <td>{{ $time->istirahat }}</td>
                    <td>{{ $time->jam_operasi - $time->istirahat }}</td>
                @else
                    <td>{{ $time->hm_awal }}</td>
                    <td>{{ $time->hm_akhir }}</td>
                    <td>{{ $time->istirahat }}</td>
                    <td>{{ $time->hm_akhir - $time->hm_awal - $time->istirahat }}</td>
                @endif
                <td>{{ $time->keterangan }}</td>
            </tr>
                @php
                    if($time->tipe == 'jam'){
                        $jamtotal = $jamtotal+$time->jam_operasi - $time->istirahat;
                    }
                    else{
                        $jamtotal = $time->hm_akhir - $time->hm_awal - $time->istirahat;
                    }
                @endphp
            @endforeach 
            <tr>
                <td colspan="6">
                    Jumlah Total
                </td>
                <td>{{ $jamtotal }}</td>
                <td></td>
            </tr>
            </table>
            @if ($urut++ < $jumlah )
                <div class="page_break"></div>
            @endif
            
        @endforeach
    </body>

</html>