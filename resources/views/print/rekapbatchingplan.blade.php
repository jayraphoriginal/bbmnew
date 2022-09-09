<html>

    <head>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <title>Rekap Batching Plan</title>
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
    </style>

    <body>
        
        <h3 style="margin-bottom: 3rem;text-align:center">REKAP BATCHING PLAN</h3>
        <table class="table table-striped table-bordered mytable">
            <tr>
                <td class="tdhead">No</td>
                <td class="tdhead">Tanggal</td>
                <td class="tdhead">Nama Customer</td>
                <td class="tdhead">Kode Mutu</td>
                <td class="tdhead">Jumlah</td>
                <td class="tdhead">Satuan</td>
            </tr>
            
            @php
                $total = 0;
            @endphp
            @foreach($data as $index => $item)
            <tr>
                <td>{{ ++$index }}</td>
                <td>{{ $item->jam_pengiriman }}</td>
                <td>{{ $item->nama_customer }}</td>
                <td>{{ $item->kode_mutu }}</td>
                <td>{{ $item->volume }}</td>
                <td>{{ $item->satuan }}</td>
            </tr>
                @php
                    $total = $total + $item->volume;
                @endphp
            @endforeach 
            <tr>
                <td colspan="4">Total</td>
                <td colspan="2">{{ number_format($total,2,',','.') }}</td>
            </tr>
        </table>

    </body>

</html>