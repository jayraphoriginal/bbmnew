<html>

    <head>
        <title>Laporan Penjualan Barang</title>
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
        
        <h2 style="text-align:center; font-size:18px;">Laporan Pendapatan Penjualan Barang</h2>
        @if (count($datacustomer) > 0)
        <h3 style="font-size:14px;font-weight:bold;">Pendapatan Penjualan Barang Per Periode Per Customer</h3>
        <h3 style="margin-bottom: 1rem;font-size:14px;">Periode : {{ date_format(date_create($tgl_awal),'d/M/Y').' - '.date_format(date_create($tgl_akhir),'d/M/Y') }}</h3>
        <table class="mytable" style="width:100%">
            <tr>
                <td class="tdhead">No</td>
                <td class="tdhead">Customer</td>
                <td class="tdhead">Nama Barang</td>
                <td class="tdhead text-right">Jumlah</td>
                <td class="tdhead text-right">Harga</td>
                <td class="tdhead text-right">Total Harga</td>
                <td class="tdhead">Lokasi</td>
            </tr>
            
            @php
                $total = 0;
                $totalpenjualan = 0;
            @endphp
            @foreach($datacustomer as $index => $item)
            <tr>
                <td>{{ ++$index }}</td>
                <td>{{ $item->nama_customer }}</td>
                <td>{{ $item->kode_mutu }}</td>
                <td class="text-right">{{ number_format($item->total,2,',','.').' '.$item->satuan }}</td>
                <td class="text-right">{{ number_format($item->harga,2,',','.') }}</td>
                <td class="text-right">{{ number_format($item->harga*$item->total,2,',','.') }}</td>
                <td>{{ $item->tujuan}}</td>
            </tr>
                @php
                    $total = $total + $item->total;
                    $totalpenjualan = $totalpenjualan + ($item->harga*$item->total);
                @endphp
            @endforeach 
            <tr>
                <td colspan="3" style="font-weight:bold">Total</td>
                <td class="text-right" style="font-weight:bold">{{ number_format($total,2,',','.').' '.$datacustomer[0]->satuan }}</td>
                <td></td>
                <td class="text-right" style="font-weight:bold">{{ number_format($totalpenjualan,2,',','.') }}</td>
                <td></td>
            </tr>
        </table>
        @endif
    </body>

</html>