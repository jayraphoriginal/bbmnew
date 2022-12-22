<html>

    <head>
        <title>Laporan Pemakaian Concrete Pump</title>
    </head>

    <style>
        .mytable>tbody>tr>td, .mytable>tbody>tr>th, .mytable>tfoot>tr>td, .mytable>tfoot>tr>th, .mytable>thead>tr>td, .mytable>thead>tr>th {
            padding: 5px;
            vertical-align: middle;
            border:1px solid;
            margin:0;
        }
         table{
            border-collapse: collapse;
        }
        *{
            font-size:13px;
        }
        @page{
            margin: 0.3in 0.3in 0.2in 0.3in;
        }
        .page_break { 
            page-break-before: always; 
        }
        .tdhead{
            font-weight: bold;
        }
        .text-right{
            text-align: right;
        }
    </style>

    <body>
        
        <p style="text-align:center;font-size:16px;font-weight:bold">Laporan Pemakaian Concrete Pump</p>
        @if (count($data) > 0)
        <p style="margin-bottom: 3rem;text-align:center">Periode : {{ date_format(date_create($tgl_awal),'d/M/Y').' - '.date_format(date_create($tgl_akhir),'d/M/Y') }}</p>
        <table class="mytable" style="width:100%">
            <tr>
                <td rowspan="2" class="tdhead" style="text-align:center">No</td>
                <td rowspan="2" class="tdhead" style="text-align:center">Tanggal</td>
                <td rowspan="2" class="tdhead" style="text-align:center">Customer</td>
                <td rowspan="2" class="tdhead" style="text-align:center">Lokasi</td>
                <td colspan="2" class="tdhead" style="text-align:center">Waktu Operasi</td>
                <td style="font-weight: bold;text-align:center;width:50px;" rowspan="2">Jumlah Waktu Operasi</td>
                <td style="font-weight: bold;text-align:center" rowspan="2">Volume</td>
                <td style="font-weight: bold;text-align:center" rowspan="2">Nilai</td>
            </tr>

            <tr>
                <td class="tdhead" style="text-align:center">Awal</td>
                <td class="tdhead" style="text-align:center">Akhir</td>
            </tr>
            
            @php
                $total = 0;
                $totalvolume = 0;
                $totaljam=0;
                $totalmenit=0
            @endphp
            @foreach($data as $index => $item)
            <tr>
                <td>{{ ++$index }}</td>
                <td>{{ date_format(date_create($item->tanggal),'d-m-Y') }}</td>
                <td>{{ $item->nama_customer }}</td>
                <td>{{ $item->tujuan }}</td>
                <td style="text-align:center">{{ date_format(date_create($item->jam_awal),'H:i') }}</td>
                <td style="text-align:center">{{ date_format(date_create($item->jam_akhir),'H:i') }}</td>
                <td style="text-align:center">{{ date_diff(date_create($item->jam_awal),date_create($item->jam_akhir))->format('%H:%I') }}</td>
                <td class="text-right">{{ number_format($item->volume,1,',','.') }} M<sup>3</sup></td>
                <td class="text-right">{{ number_format($item->harga_sewa,0,'.',',') }}</td>
            </tr>
                @php
                    $total = $total + $item->harga_sewa;
                    $totalvolume = $totalvolume + $item->volume;
                    $totaljam = $totaljam + intval(date_diff(date_create($item->jam_awal),date_create($item->jam_akhir))->format('%H'));
                    $totalmenit = $totalmenit + intval(date_diff(date_create($item->jam_awal),date_create($item->jam_akhir))->format('%I'))
                @endphp
            @endforeach 
            <tr>
                <td colspan="6" style="font-weight:bold">Total</td>
                <td style="font-weight:bold;text-align:center">{{ $totaljam + intdiv($totalmenit,60) .':'.fmod($totalmenit, 60) }}</td>
                <td class="text-right" style="font-weight:bold">{{ number_format($totalvolume,1,'.',',') }} M<sup>3</sup></td>
                <td class="text-right" style="font-weight:bold">{{ number_format($total,0,'.',',')}}</td>
            </tr>
        </table>
        @endif
    </body>

</html>