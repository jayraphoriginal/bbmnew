<html>

    <head>
        <title>LAPORAN STOK PRODUK TURUNAN</title>
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
        
        <h4 style="text-align:center">LAPORAN STOK PRODUK TURUNAN</h4>
        <p>Tanggal : {{ date_create($tgl_awal)->format('d/m/Y') }} - {{ date_create($tgl_akhir)->format('d/m/Y') }}</p>
        @if (count($data) > 0)
        <table class="mytable" style="width: 100%;">
            <tr>
                <td class="tdhead">No</td>
                <td class="tdhead">Nama Barang</td>
                <td class="tdhead text-right" >Stok Awal</td>
                <td class="tdhead text-right">Masuk</td>
                <td class="tdhead text-right">Keluar</td>
                <td class="tdhead text-right">Stok Akhir</td>
                <td class="tdhead text-right">Saldo</td>
            </tr>
            
            @php
                $total= 0;
            @endphp
            @foreach($data as $index => $item)
            <tr>
                <td>{{ ++$index }}</td>
                <td>{{ $item->nama_barang }}</td>
                <td class="text-right">{{ number_format($item->stok_awal,2,',','.') }}</td>
                <td class="text-right">{{ number_format($item->masuk,4,',','.') }}</td>
                <td class="text-right">{{ number_format($item->keluar,4,',','.') }}</td>
                <td class="text-right">{{ number_format($item->stok_akhir,4,'.',',') }}</td>
                <td class="text-right">{{ number_format($item->saldo,4,'.',',') }}</td>
            </tr>
                @php
                    $total=$total+$item->saldo;
                @endphp
            @endforeach 
            <tr>
                <td colspan="6" style="font-weight:bold">Total</td>
                <td class="text-right" style="font-weight:bold">{{ number_format($total,4,',','.') }}</td>
            </tr>
        </table>
        @endif
    </body>

</html>