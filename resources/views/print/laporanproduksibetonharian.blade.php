<html>

    <head>
        <title>Laporan Produksi Beton per Hari</title>
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
        table{
            border-collapse: collapse;
        }
        .text-right{
            text-align: right;
        }
    </style>

    <body>
        
        <h4 style="text-align:center">Laporan Produksi Beton per Hari</h4>
        @if (count($data) > 0)
        <h5 style="margin-bottom: 3rem;">Periode : {{ date_format(date_create($tgl_awal),'d/m/Y').' - '.date_format(date_create($tgl_akhir),'d/m/Y') }}</h5>
        <table class="mytable" style="width: 100%;">
            <tr>
                <td class="tdhead">No</td>
                <td class="tdhead">Tanggal</td>
                <td class="tdhead">Jumlah Customer</td>
                <td class="tdhead">Jumlah Mutubeton</td>
                <td class="tdhead">Jumlah Ticket</td>
                <td class="tdhead">Jumlah Produksi</td>
                <td class="tdhead">Nilai Penjualan</td>
            </tr>
            
            @php
                $total = 0;
                $totalticket = 0;
                $totalpenjualan = 0;
            @endphp
            @foreach($data as $index => $item)
            <tr>
                <td>{{ ++$index }}</td>
                <td>{{ $item->tanggal }}</td>
                <td class="text-right">{{ $item->jumlah_customer }}</td>
                <td class="text-right">{{ $item->jumlah_mutubeton }}</td>
                <td class="text-right">{{ $item->jumlah_ticket }}</td>
                <td class="text-right">{{ number_format($item->jumlah,2,',','.').' M'}}<sup>3</sup></td>
                <td class="text-right">{{ number_format($item->jumlah_penjualan,2,',','.') }}</td>
            </tr>
                @php
                        $total = $total + $item->jumlah;
                        $totalticket = $totalticket + $item->jumlah_ticket;
                        $totalpenjualan = $totalpenjualan + $item->jumlah_penjualan;
                @endphp
            @endforeach 
            <tr>
                <td colspan="4" style="font-weight:bold">Total</td>
                <td class="text-right" style="font-weight:bold">{{ number_format($totalticket,0,',','.')}}</td>
                <td class="text-right" style="font-weight:bold">{{ number_format($total,2,',','.').' M'}}<sup>3</sup></td>
                <td class="text-right" style="font-weight:bold">{{ number_format($totalpenjualan,0,',','.')}}</td>
            </tr>
        </table>

        <table style="width:50%;margin-top:20px;">
            <tr>
                <td style="width:70%;">Jumlah Hari Produksi</td>
                <td style="width:5%">=</td>
                <td style="width:25%" class="text-right">{{ $index }} Hari</td>
            </tr>
            <tr>
                <td style="width:70%;">Rata Produksi per Hari</td>
                <td style="width:5%">=</td>
                <td style="width:25%" class="text-right">{{ number_format($total/$index,2,',','.') }} M<sup>3</sup></td>
            </tr>
            <tr>
                <td style="width:70%;">Tanggal Produksi Tertinggi - {{ $max->tanggal }}</td>
                <td style="width:5%">=</td>
                <td style="width:25%" class="text-right">{{ number_format($max->jumlah_max,2,',','.').' M3' }}</td>
            </tr>
            <tr>
                <td style="width:70%;">Tanggal Produksi Terendah - {{ $min->tanggal }}</td>
                <td style="width:5%">=</td>
                <td style="width:25%" class="text-right">{{ number_format($min->jumlah_min,2,',','.').' M3' }}</td>
            </tr>
            
        </table>
        @endif


    </body>

</html>