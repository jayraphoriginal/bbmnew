<html>

    <head>
       <title>Laporan Pembelian</title>
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
        
        <h4 style="text-align:center">LAPORAN PEMBELIAN</h4>
        <table style="margin-bottom: 20px;">
            <tr>
                <td>Periode</td>
                <td>:</td>
                <td>{{ date_format(date_create($tgl_awal),'d/M/Y').' - '.date_format(date_create($tgl_akhir),'d/M/Y') }}</td>
            </tr>
        </table>
        @if (count($data) > 0)
        <table class="mytable" style="width:100%">
            <tr>
                <td class="tdhead">No</td>
                <td class="tdhead">NoPO</td>
                <td class="tdhead">Tanggal</td>
                <td class="tdhead">Jenis Pembebanan</td>
                <td class="tdhead">Dibebankan di</td>
                <td class="tdhead">Nama Supplier</td>
                <td class="tdhead">Nama Barang</td>
                <td class="tdhead">Jumlah</td>
                <td class="tdhead">Harga</td>
                <td class="tdhead">DPP</td>
                <td class="tdhead">PPN</td>
                <td class="tdhead">Subtotal PPN</td>
                <td class="tdhead">Subtotal</td>
            </tr>
            
            @php
                $total= 0;
                $totalppn=0;
            @endphp
            @foreach($data as $index => $item)
            <tr>
                <td>{{ ++$index }}</td>
                <td>{{ $item->nopo }}</td>
                <td>{{ date_format(date_create($item->tgl_masuk),'d/M/Y') }}</td>
                <td>{{ $item->jenis_pembebanan }}</td>
                <td>{{ $item->Alken }}</td>
                <td>{{ $item->nama_supplier }}</td>
                <td>{{ $item->nama_barang }}</td>
                <td class="text-right">{{ number_format($item->jumlah,4,'.',',') }}</td>
                <td class="text-right">{{ number_format($item->harga,2,'.',',') }}</td>
                <td class="text-right">{{ number_format($item->harga/(1+ ($item->pajak/100)),2,'.',',') }}</td>
                <td class="text-right">{{ number_format($item->harga - ($item->harga/(1+ ($item->pajak/100))),2,'.',',') }}</td>
                <td class="text-right">{{ number_format($item->jumlah*($item->harga - ($item->harga/(1+ ($item->pajak/100)))),2,'.',',') }}</td>
                <td class="text-right">{{ number_format($item->jumlah*$item->harga,2,'.',',') }}</td>
            </tr>
                @php
                    $total=$total+$item->jumlah*$item->harga;
                    $totalppn=$totalppn+($item->jumlah*($item->harga - ($item->harga/(1+ ($item->pajak/100)))));
                @endphp
            @endforeach 
            <tr>
                <td colspan="11" style="font-weight:bold">Total</td>
                <td class="text-right" style="font-weight:bold">{{ number_format($totalppn,2,',','.') }}</td>
                <td class="text-right" style="font-weight:bold">{{ number_format($total,2,',','.') }}</td>
            </tr>
        </table>
        @endif
    </body>

</html>