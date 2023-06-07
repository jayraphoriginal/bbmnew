<html>

    <head>
        <title>Laporan Giro Masuk</title>
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
        table{
            border-collapse: collapse;
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
        .text-right{
            text-align: right;
        }
    </style>

    <body>
        <h4 style="text-align:center">LAPORAN WARKAT MASUK</h4>
        @if (count($data) > 0)
        <p style="margin-bottom: 3rem;">Periode : {{ date_format(date_create($tgl_awal),'d/M/Y').' - '.date_format(date_create($tgl_akhir),'d/M/Y') }}</p>
       
        <table class="mytable" style="width:100%">
            <tr>
                <td class="tdhead">No</td>
                <td class="tdhead">Tanggal</td>
                <td class="tdhead">Nama Customer</td>
                <td class="tdhead">Keterangan</td>
                <td class="tdhead">No Warkat</td>
                <td class="tdhead">Jatuh Tempo</td>
                <td class="tdhead">Tanggal Cair</td>
                <td class="tdhead">Jumlah</td>
            </tr>
            
            @php
                $total=0;
            @endphp
            @foreach($data as $index => $item)
            <tr>
                <td>{{ ++$index }}</td>
                <td>{{ date_format(date_create($item->tgl_bayar),'d/M/Y') }}</td>
                <td>{{ $item->nama_customer }}</td>
                <td>{{ $item->keterangan }}</td>
                <td>{{ $item->nowarkat }}</td>
                <td>{{ date_format(date_create($item->jatuh_tempo),'d/M/Y') }}</td>
                @if(!is_null($item->tgl_cair))
                    <td>{{ date_format(date_create($item->tgl_cair),'d/M/Y') }}</td>
                @else
                    <td></td>
                @endif
                <td class="text-right">{{ number_format($item->jumlah,2,'.',',') }}</td>
            </tr>
                @php
                    $total = $total + $item->jumlah;
                @endphp
            @endforeach
            <tr>
                <td colspan="7" style="font-weight:bold">Total</td>
                <td class="text-right" style="font-weight:bold">{{ number_format($total,2,',','.') }}</td>
            </tr>
        </table>
        @endif
    </body>

</html>