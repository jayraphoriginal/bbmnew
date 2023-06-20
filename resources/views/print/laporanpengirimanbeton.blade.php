<html>

    <head>
        <title>Laporan Pengiriman Beton</title>
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
        .page_break { 
            page-break-before: always; 
        }
        .tdhead{
            font-weight: bold;
        }
        table{
            border-collapse: collapse;
        }
        .text-right{
            text-align: right;
        }
    </style>

    <body>
        
        <h4 style="text-align:center">Laporan Pengiriman Beton</h4>
        @if (count($data) > 0)
        <h5 style="margin-bottom: 3rem;">Periode : {{ date_format(date_create($tgl_awal),'d/m/Y').' - '.date_format(date_create($tgl_akhir),'d/m/Y') }}</h5>
        <table class="mytable" style="width: 100%;">
            <tr>
                <td class="tdhead">No</td>
                <td class="tdhead">Customer</td>
                <td class="tdhead">Nopol</td>
                <td class="tdhead">No Ticket</td>
                <td class="tdhead">Tanggal</td>
                <td class="tdhead">Jam Berangkat</td>
                <td class="tdhead">Mutu Beton</td>
                <td class="tdhead text-right">Volume</td>
                <td class="tdhead">Lokasi</td>
                <td class="tdhead">Driver</td>
            </tr>
            
            @php
                $total = 0;
            @endphp
            @foreach($data as $index => $item)
            <tr>
                <td>{{ ++$index }}</td>
                <td>{{ $item->nama_customer }}</td>
                <td>{{ $item->nopol }}</td>
                <td>{{ $item->noticket }}</td>
                <td>{{ date_format(date_create($item->jam_ticket),'d/m/Y') }}</td>
                <td>{{ date_format(date_create($item->jam_ticket),'h:i:s') }}</td>
                <td>{{ $item->kode_mutu }}</td>
                <td class="text-right">{{ number_format($item->jumlah,2,',','.').' '.$item->satuan }}</td>
                <td>{{ $item->tujuan}}</td>
                <td>{{ $item->nama_driver}}</td>
            </tr>
                @php
                        $total = $total + $item->jumlah;
                @endphp
            @endforeach 
            <tr>
                <td colspan="7" style="font-weight:bold">Total</td>
                <td class="text-right" style="font-weight:bold">{{ number_format($total,2,',','.').' '.$data[0]->satuan }}</td>
                <td colspan="2"></td>
            </tr>
        </table>
        @endif
    </body>

</html>