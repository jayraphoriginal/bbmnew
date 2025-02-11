<html>

    <head>
       <title>Penjualan Mutu Beton</title>
    </head>

    <style>
        .mytable>tbody>tr>td, .mytable>tbody>tr>th, .mytable>tfoot>tr>td, .mytable>tfoot>tr>th, .mytable>thead>tr>th {
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
        
        <h4 style="text-align:center">Laporan Penjualan Per Mutu Beton</h4>
        @if (count($data) > 0)
        <h5 style="margin-bottom: 3rem;text-align:center">Periode : {{ date_format(date_create($tgl_awal),'d/M/Y').' - '.date_format(date_create($tgl_akhir),'d/M/Y') }}</h5>
        <table class="mytable" style="width:100%">
            <tr>
                <td class="tdhead">No</td>
                <td class="tdhead">Kode Mutu</td>
                <td class="tdhead">Deskripsi</td>
                <td class="tdhead text-right">Jumlah M<sup>3</sup></td>
                <td class="tdhead text-right">Total</td>
            </tr>
            
            @php
                $total = 0;
                $totalkubik = 0;
            @endphp
            @foreach($data as $index => $item)
            <tr>
                <td>{{ ++$index }}</td>
                <td>{{ $item->kode_mutu }}</td>
                <td>{{ $item->deskripsi }}</td>
                <td class="text-right">{{ number_format($item->jumlah,2,',','.') }} M<sup>3</sup></td>
                <td class="text-right">{{ number_format($item->total,2,',','.') }}</td>
            </tr>
                @php
                    $totalkubik = $totalkubik + $item->jumlah;
                    $total = $total + $item->total;
                @endphp
            @endforeach 
            <tr>
                <td colspan="3" style="font-weight:bold">Total</td>
                <td class="text-right" style="font-weight:bold">{{ number_format($totalkubik,2,',','.') }} M<sup>3</sup></td>
                <td class="text-right" style="font-weight:bold">{{ number_format($total,2,',','.') }}</td>
            </tr>
        </table>
        @endif
    </body>

</html>