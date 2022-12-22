<html>

    <head>
        <title>Rekap Pengeluaran Biaya</title>
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
        
        <h2 style="text-align:center; font-size:18px;">Rekap Pengeluaran Biaya</h2>
        @if (count($data) > 0)
        <h3 style="margin-bottom: 3rem;text-align:center; font-size:16px;">Periode : {{ date_format(date_create($tgl_awal),'d/M/Y').' - '.date_format(date_create($tgl_akhir),'d/M/Y') }}</h3>
        <table class="mytable" style="width:100%">
            <tr>
                <td class="tdhead">No</td>
                <td class="tdhead">Tgl Biaya</td>
                <td class="tdhead">Nama Supplier</td>
                <td class="tdhead text-right">Pembayaran</td>
                <td class="tdhead">Bank</td>
                <td class="tdhead">Biaya</td>
                <td class="tdhead">Jenis Pembebanan</td>
                <td class="tdhead">Dibebankan di</td>
                <td class="tdhead">Jumlah</td>
                <td class="tdhead">Keterangan</td>
            </tr>
            
            @php
                $total = 0;
                $totaldpp = 0;
                $totalppn = 0;
            @endphp
            @foreach($data as $index => $item)
            <tr>
                <td>{{ ++$index }}</td>
                <td>{{ date_create($item->tgl_biaya)->format('d-m-y') }}</td>
                <td>{{ $item->nama_supplier }}</td>
                <td>{{ $item->tipe_pembayaran }}</td>
                <td>{{ $item->kode_bank.' - '.$item->norek }}</td>
                <td>{{ $item->nama_biaya }}</td>
                <td>{{ $item->jenis_pembebanan }}</td>
                <td>{{ $item->alken }}</td>
                <td class="text-right">{{ number_format($item->jumlah,2,',','.') }}</td>
                <td>{{ $item->keterangan }}</td>
            </tr>
                @php
                    $total = $total + $item->jumlah;
                @endphp
            @endforeach 
            <tr>
                <td colspan="8" style="font-weight:bold">Total</td>
                <td class="text-right" style="font-weight:bold">{{ number_format($total,2,',','.') }}</td>
                <td></td>
            </tr>
        </table>
        @endif
    </body>

</html>