<html>

    <head>
        <title>Laporan Kartu Stok</title>
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
        <h4 style="text-align:center">LAPORAN KARTU STOK</h4>  
        <p>Barang : {{ $data[0]->nama_barang }}</p>
        <p style="margin-bottom: 1rem;">Periode : {{ date_format(date_create($tgl_awal),'d/m/Y').' - '.date_format(date_create($tgl_akhir),'d/m/Y') }}</p>
        
        <table class="mytable" style="width:100%">
            <tr>
                <td class="tdhead">No</td>
                <td class="tdhead">Tanggal</td>
                <td class="tdhead">Keterangan</td>
                <td class="tdhead">Masuk</td>
                <td class="tdhead">Keluar</td>
                <td class="tdhead">Stok</td>
                <td class="tdhead">Debet</td>
                <td class="tdhead">Kredit</td>
            </tr>
            @php
                $totalincrease = 0;
                $totaldecrease = 0;
                $totaldebet=0;
                $totalkredit=0;
            @endphp
            @foreach($data as $index => $item)
            <tr>
                <td>{{ ++$index }}</td>
                <td>{{ date_format(date_create($item->tanggal),'d/m/Y') }}</td>
                <td>{{ $item->tipe }}</td>
                <td class="text-right">{{ number_format($item->increase,4,'.',',') }}</td>
                <td class="text-right">{{ number_format($item->decrease,4,'.',',') }}</td>
                <td class="text-right">{{ number_format($item->qty,2,'.',',') }}</td>
                <td class="text-right">{{ number_format($item->increase*$item->harga_debet,2,'.',',') }}</td>
                <td class="text-right">{{ number_format($item->decrease*$item->harga_kredit,2,'.',',') }}</td>
            </tr>
                @php
                    $totalincrease = $totalincrease + $item->increase;
                    $totaldecrease = $totaldecrease + $item->decrease;
                    $totaldebet = $totaldebet + ($item->increase*$item->harga_debet);
                    $totalkredit = $totalkredit + ($item->decrease*$item->harga_kredit);
                @endphp
            @endforeach 
            <tr>
                <td colspan="3" style="font-weight:bold">Total</td>
                <td class="text-right" style="font-weight:bold">{{ number_format($totalincrease,4,',','.') }}</td>
                <td class="text-right" style="font-weight:bold">{{ number_format($totaldecrease,4,',','.') }}</td>
                <td></td>
                <td class="text-right" style="font-weight:bold">{{ number_format($totaldebet,2,',','.') }}</td>
                <td class="text-right" style="font-weight:bold">{{ number_format($totalkredit,2,',','.') }}</td>
            </tr>
        </table>
        @endif
    </body>

</html>