<html>

    <head>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <title>Rekap Ticket Material</title>
    </head>

    <style>
        .mytable>tbody>tr>td, .mytable>tbody>tr>th, .mytable>tfoot>tr>td, .mytable>tfoot>tr>th, .mytable>thead>tr>td, .mytable>thead>tr>th {
            padding: 5px;
            vertical-align: middle;
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
    </style>

    <body>
        
        <h4 style="text-align:center">Rekap Penjualan Ready Mix</h4>
        @if (count($data) > 0)
        <h5 style="margin-bottom: 3rem;text-align:center">Periode : {{ date_format(date_create($data[0]->tgl_awal),'d/M/Y').' - '.date_format(date_create($data[0]->tgl_akhir),'d/M/Y') }}</h5>
        <table class="table table-striped table-bordered mytable">
            <tr>
                <td class="tdhead">No</td>
                <td class="tdhead">Tanggal</td>
                <td class="tdhead">Nopol</td>
                <td class="tdhead">Kode Mutu</td>
                <td class="tdhead text-right">Jumlah</td>
                <td class="tdhead">Customer</td>
                <td class="tdhead">Lokasi</td>
            </tr>
            
            @php
                $total = 0;
            @endphp
            @foreach($data as $index => $item)
            <tr>
                <td>{{ ++$index }}</td>
                <td>{{ date_format(date_create($item->jam_pengiriman),'d-m-Y') }}</td>
                <td>{{ $item->nopol }}</td>
                <td>{{ $item->kode_mutu }}</td>
                <td class="text-right">{{ $item->jumlah.' '.$item->satuan }}</td>
                <td>{{ $item->nama_customer }}</td>
                <td>{{ $item->tujuan}}</td>
            </tr>
                @php
                    $total = $total + $item->jumlah;
                @endphp
            @endforeach 
            <tr>
                <td colspan="4" style="font-weight:bold">Total</td>
                <td class="text-right" style="font-weight:bold">{{ number_format($total,0,',','.').' '.$data[0]->satuan }}</td>
                <td colspan="2"></td>
            </tr>
        </table>
        @endif
    </body>

</html>