<html>

    <head>
        <title>Laporan Penjualan Beton</title>
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
        
        <h2 style="text-align:center; font-size:18px;">Laporan Penjualan Beton per Mobil</h2>
        @if (count($data) > 0)
        <p style="font-size:14px;">Periode : {{ date_format(date_create($tgl_awal),'d/M/Y').' - '.date_format(date_create($tgl_akhir),'d/M/Y') }}</p>
        <p style="margin-bottom: 3rem; font-size:14px;">Nopol : {{ $data[0]->nopol }}</p>
        <table class="mytable" style="width:100%">
            <tr>
                <td class="tdhead">No</td>
                <td class="tdhead">NoSO</td>
                <td class="tdhead">Tanggal</td>
                <td class="tdhead">Customer</td>
                <td class="tdhead">Nama Driver</td>
                <td class="tdhead">No Ticket</td>
                <td class="tdhead">Kode Mutu</td>
                <td class="tdhead text-right">Jumlah</td>
                <td class="tdhead">Lokasi</td>
            </tr>
            
            @php
                $total = 0;
            @endphp
            @foreach($data as $index => $item)
            <tr>
                <td>{{ ++$index }}</td>
                <td>{{ $item->noso }}</td>
                <td>{{ date_create($item->jam_ticket)->format('d-m-y') }}</td>
                <td>{{ $item->nama_customer }}</td>
                <td>{{ $item->nama_driver }}</td>
                <td>{{ $item->noticket }}</td>
                <td>{{ $item->kode_mutu }}</td>
                <td class="text-right">{{ number_format($item->jumlah,1,',','.').' '.$item->satuan }}</td>
                <td>{{ $item->tujuan }} </td>
            </tr>
                @php
                    $total = $total + $item->jumlah;
                @endphp
            @endforeach 
            <tr>
                <td colspan="7" style="font-weight:bold">Total</td>
                <td class="text-right" style="font-weight:bold">{{ number_format($total,1,',','.').' '.$data[0]->satuan }}</td>
                <td></td>
            </tr>
        </table>
        @endif
    </body>

</html>