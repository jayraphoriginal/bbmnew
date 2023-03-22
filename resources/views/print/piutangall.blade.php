<html>

    <head>
        <title>Rekap Piutang Customer</title>
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
        table{
            border-collapse: collapse;
        }
        .tdhead{
            font-weight: bold;
        }
        .text-right{
            text-align:right;
        }
    </style>

    <body>
        
        <h4 style="text-align:center;font-size:14px">Rekap Piutang Customer</h4>
        @if (count($data) > 0)
        <h5 style="margin-bottom: 3rem;text-align:center">Per Tanggal : {{ date_format(date_create($tanggal),'d/M/Y') }}</h5>
        <table class="mytable" style="width:100%">
            <tr>
                <td class="tdhead" style="text-align:center">No</td>
                <td class="tdhead">Nama Customer</td>
                <td class="tdhead">Sub Company</td>
                <td class="tdhead">Nama Pemilik</td>
                <td class="tdhead">Saldo Piutang</td>
            </tr>
            
            @php
                $total = 0;
            @endphp
            @foreach($data as $index => $item)
            <tr>
                <td style="text-align:center">{{ ++$index }}</td>
                <td>{{ $item->nama_customer }}</td>
                <td>{{ $item->sub_company }}</td>
                <td>{{ $item->nama_pemilik }}</td>
                <td class="text-right">{{ number_format($item->saldo,2,',','.') }}</td>
            </tr>
                @php
                    $total = $total + $item->saldo;
                @endphp
            @endforeach 
            <tr>
                <td colspan="4" style="font-weight:bold">Total</td>
                <td class="text-right" style="font-weight:bold">{{ number_format($total,2,',','.') }}</td>
            </tr>
        </table>
        @endif
    </body>

</html>