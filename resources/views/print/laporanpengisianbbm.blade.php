<html>

    <head>
        <title>Laporan Pengisian Bbm</title>
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
        table{
            border-collapse: collapse;
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
        
        <h4 style="text-align:center">LAPORAN PENGISIAN BBM</h4>
        <h5 style="margin-bottom: 3rem;">Periode : {{ date_format(date_create($tgl_awal),'d/M/Y').' - '.date_format(date_create($tgl_akhir),'d/M/Y') }}</h5>
        @if (count($data) > 0)
        <table class="mytable" style="width: 100%;">
            <tr>
                <td class="tdhead">No</td>
                <td class="tdhead">Tanggal</td>
                <td class="tdhead">Nama Supplier</td>
                <td class="tdhead">Nopol</td>
                <td class="tdhead">Nama Driver</td>
                <td class="tdhead">Bahan Bakar</td>
                <td class="tdhead">Jumlah</td>
                <td class="tdhead">Harga</td>
                <td class="tdhead">Subtotal</td>
            </tr>
            
            @php
                $total= 0;
            @endphp
            @foreach($data as $index => $item)
            <tr>
                <td>{{ ++$index }}</td>
                <td>{{ date_format(date_create($item->tanggal_pengisian),'d/M/Y') }}</td>
                <td>{{ $item->nama_supplier }}</td>
                <td>{{ $item->nopol }}</td>
                <td>{{ $item->nama_driver }}</td>
                <td>{{ $item->bahan_bakar }}</td>
                <td class="text-right">{{ number_format($item->jumlah,2,'.',',') }}</td>
                <td class="text-right">{{ number_format($item->harga,2,'.',',') }}</td>
                <td class="text-right">{{ number_format($item->jumlah*$item->harga,2,'.',',') }}</td>
            </tr>
                @php
                    $total=$total+$item->jumlah*$item->harga;
                @endphp
            @endforeach 
            <tr>
                <td colspan="8" style="font-weight:bold">Total</td>
                <td class="text-right" style="font-weight:bold">{{ number_format($total,2,',','.') }}</td>
            </tr>
        </table>
        @endif
    </body>

</html>