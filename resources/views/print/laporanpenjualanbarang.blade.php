<html>

    <head>
        <title>Laporan Penjualan Barang</title>
    </head>

    <style>
        .mytable>tbody>tr>td, .mytable>tbody>tr>th, .mytable>tfoot>tr>td, .mytable>tfoot>tr>th, .mytable>thead>tr>td, .mytable>thead>tr>th {
            padding: 5px;
            vertical-align: middle;
            border: 1px solid;
        }
       *{
            font-size:13px;
        }
        table{
            border-collapse: collapse;
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
        .text-right{
            text-align: right;
        }
    </style>

    <body>
        @if (count($data) > 0)
        <h4 style="text-align:center">LAPORAN PENJUALAN BARANG</h4>  
        @if (!is_null($barang_id))
            <p>Barang : {{ $data[0]->nama_barang }}</p>
        @endif
        <p style="margin-bottom: 3rem;">Periode : {{ date_format(date_create($tgl_awal),'d/M/Y').' - '.date_format(date_create($tgl_akhir),'d/M/Y') }}</p>
        
        <table class="mytable" style="width:100%">
            <tr>
                <td class="tdhead">No</td>
                <td class="tdhead">No Surat Jalan</td>
                <td class="tdhead">Tgl Pengiriman</td>
                <td class="tdhead">Nama Customer</td>
                <td class="tdhead">Tujuan</td>
                <td class="tdhead">Nopol</td>
                <td class="tdhead">Driver</td>
                <td class="tdhead">Nama Barang</td>
                <td class="tdhead text-right">Jumlah</td>
                <td class="tdhead text-right">Harga</td>
                <td class="tdhead text-right">Subtotal</td>
            </tr>
            @php
                $total=0;
                $totalbarang = 0;
            @endphp
            @foreach($data as $index => $item)
            <tr>
                <td>{{ ++$index }}</td>
                <td>{{ $item->nosuratjalan }}</td>
                <td>{{ date_format(date_create($item->tgl_pengiriman),'d/m/Y') }}</td>
                <td>{{ $item->nama_customer }}</td>
                <td>{{ $item->tujuan }}</td>
                <td>{{ $item->nopol }}</td>
                <td>{{ $item->driver }}</td>
                <td>{{ $item->nama_barang }}</td>    
                <td class="text-right">{{ number_format($item->jumlah,0,'.',',').' '.$item->satuan }} </td>
                <td class="text-right">{{ number_format($item->harga_intax,4,'.',',') }}</td>
                <td class="text-right">{{ number_format($item->harga_intax*$item->jumlah,4,'.',',') }}</td>
            </tr>
                @php
                    $total = $total + $item->harga_intax*$item->jumlah;
                    $totalbarang = $totalbarang + $item->jumlah;
                @endphp
            @endforeach 
            <tr>
                <td colspan="8" style="font-weight:bold">Total</td>
                <td class="text-right" style="font-weight:bold">{{ number_format($totalbarang,4,',','.') }}</td>
                <td></td>
                <td class="text-right" style="font-weight:bold">{{ number_format($total,4,',','.') }}</td>
            </tr>
        </table>
        @endif
    </body>

</html>