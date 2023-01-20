<html>

    <head>
        <title>LAPORAN STOK BARANG</title>
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
        
        <h4 style="text-align:center">LAPORAN STOK BARANG</h4>
        <p>Per Tanggal : {{ Date('d/m/Y') }}</p>
        @if (count($data) > 0)
        <table class="mytable" style="width: 100%;">
            <tr>
                <td class="tdhead">No</td>
                <td class="tdhead">Nama Barang</td>
                <td class="tdhead">Merk</td>
                <td class="tdhead">Satuan</td>
                <td class="tdhead">Stok Minimum</td>
                <td class="tdhead">Stok</td>
                <td class="tdhead">Saldo</td>
            </tr>
            
            @php
                $total= 0;
            @endphp
            @foreach($data as $index => $item)
            <tr>
                <td>{{ ++$index }}</td>
                <td>{{ $item->nama_barang }}</td>
                <td>{{ $item->merk }}</td>
                <td>{{ $item->satuan }}</td>
                <td class="text-right">{{ number_format($item->stok_minimum,2,'.',',') }}</td>
                <td class="text-right">{{ number_format($item->stok,2,'.',',') }}</td>
                <td class="text-right">{{ number_format($item->saldo,2,'.',',') }}</td>
            </tr>
                @php
                    $total=$total+$item->saldo;
                @endphp
            @endforeach 
            <tr>
                <td colspan="6" style="font-weight:bold">Total</td>
                <td class="text-right" style="font-weight:bold">{{ number_format($total,2,',','.') }}</td>
            </tr>
        </table>
        @endif
    </body>

</html>