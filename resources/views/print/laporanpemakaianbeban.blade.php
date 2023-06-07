<html>

    <head>
       <title>Laporan Pemakaian Barang</title>
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
        
        <h4 style="text-align:center">LAPORAN PEMAKAIAN BARANG PER BEBAN</h4>
        <table style="margin-bottom: 20px;">
            <tr>
                <td>Alat / Kendaraan</td>
                <td>:</td>
                <td>{{ $alken }}</td>
            </tr>
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
                <td class="tdhead">Tanggal</td>
                <td class="tdhead">Biaya</td>
                <td class="tdhead">Nama Barang</td>
                <td class="tdhead">Keterangan</td>
                <td class="tdhead">Jumlah</td>
                <td class="tdhead">Total</td>
            </tr>
            
            @php
                $total= 0;
            @endphp
            @foreach($data as $index => $item)
            <tr>
                <td>{{ ++$index }}</td>
                <td>{{ date_format(date_create($item->tanggal),'d/M/Y') }}</td>
                <td>{{ $item->nama_biaya }}</td>
                <td>{{ $item->nama_barang }}</td>
                <td>{{ $item->keterangan }}</td>
                <td class="text-right">{{ number_format($item->jumlah,1,'.',',').' '.$item->satuan }}</td>
                <td class="text-right">{{ number_format($item->total,2,'.',',') }}</td>
            </tr>
                @php
                    $total=$total+$item->total;
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