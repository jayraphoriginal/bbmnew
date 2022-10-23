<html>

    <head>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <title>Laporan Pemakaian Concrete Pump</title>
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
        .tdhead{
            font-weight: bold;
        }
    </style>

    <body>
        
        <h4 style="text-align:center">Laporan Pemakaian Concrete Pump</h4>
        @if (count($data) > 0)
        <h5 style="margin-bottom: 3rem;text-align:center">Periode : {{ date_format(date_create($data[0]->tgl_awal),'d/M/Y').' - '.date_format(date_create($data[0]->tgl_akhir),'d/M/Y') }}</h5>
        <table class="table table-striped table-bordered mytable">
            <tr>
                <td rowspan="2" class="tdhead">No</td>
                <td rowspan="2" class="tdhead">Tanggal</td>
                <td rowspan="2" class="tdhead">Customer</td>
                <td rowspan="2" class="tdhead">Lokasi</td>
                <td colspan="2" class="tdhead">Waktu Operasi</td>
                <td class="text-right" style="font-weight: bold" rowspan="2" class="tdhead">Jumlah Waktu Operasi</td>
                <td class="text-right" style="font-weight: bold" rowspan="2" class="tdhead">Volume</td>
                <td class="text-right" style="font-weight: bold" rowspan="2" class="tdhead">Nilai</td>
            </tr>

            <tr>
                <td class="tdhead">Awal</td>
                <td class="tdhead">Akhir</td>
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
                <td>{{ date_format(date_create($item->jam_awal),'H:i') }}</td>
                <td>{{ date_format(date_create($item->jam_akhir),'H:i') }}</td>
                <td class="text-right">{{ date_diff(date_create($item->jam_awal),date_create($item->jam_akhir))->format('%h Jam %i Menit') }}</td>
                <td class="text-right">{{ $item->volume }} M<sup>3</sup></td>
                <td class="text-right">{{ number_format($item->harga_sewa,0,'.',',') }}</td>
            </tr>
                @php
                    $total = $total + $item->harga_sewa;
                    $totalvolume = $totalvolume + $item->volume;
                    $totaljam = $totaljam + intval(date_diff(date_create($item->jam_awal),date_create($item->jam_akhir))->format('%H'));
                    $totalmenit = $totalmenit + intval(date_diff(date_create($item->jam_awal),date_create($item->jam_akhir))->format('%i'))
                @endphp
            @endforeach 
            <tr>
                <td colspan="6" style="font-weight:bold">Total</td>
                <td class="text-right" style="font-weight:bold">{{ $totaljam + intdiv($totalmenit,60) .' Jam'.' '.fmod($totalmenit, 60).' Menit' }}</td>
                <td class="text-right" style="font-weight:bold">{{ number_format($totalvolume,0,'.',',') }} M<sup>3</sup></td>
                <td class="text-right" style="font-weight:bold">{{ number_format($total,0,'.',',')}}</td>
            </tr>
        </table>
        @endif
    </body>

</html>