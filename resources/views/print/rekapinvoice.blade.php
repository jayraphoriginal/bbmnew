<html>

    <head>
        <title>Rekap Invoice</title>
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
        
        <h2 style="text-align:center; font-size:18px;">Rekap Invoice</h2>
        @if (count($data) > 0)
        <h3 style="margin-bottom: 3rem;text-align:center; font-size:16px;">Periode : {{ date_format(date_create($tgl_awal),'d/M/Y').' - '.date_format(date_create($tgl_akhir),'d/M/Y') }}</h3>
        <table class="mytable" style="width:100%">
            <tr>
                <td class="tdhead">No</td>
                <td class="tdhead">NoInvoice</td>
                <td class="tdhead">NoSO</td>
                <td class="tdhead" style="width:8%">Tgl Cetak</td>
                <td class="tdhead">Nama Customer</td>
                <td class="tdhead text-right">Dpp</td>
                <td class="tdhead text-right">Ppn</td>
                <td class="tdhead text-right">Total</td>
            </tr>
            
            @php
                $total = 0;
                $totaldpp = 0;
                $totalppn = 0;
            @endphp
            @foreach($data as $index => $item)
            <tr>
                <td>{{ ++$index }}</td>
                <td>{{ $item->noinvoice }}</td>
                <td>{{ $item->noso }}</td>
                <td>{{ date_create($item->tgl_cetak)->format('d-m-y') }}</td>
                @if($item->tipe == 'retail' )
                    <td>{{ $item->nama_pemilik }}</td>
                @else
                    <td>{{ $item->nama_customer }}</td>
                @endif
                <td class="text-right">{{ number_format($item->dpp,2,',','.') }}</td>
                <td class="text-right">{{ number_format($item->ppn,2,',','.') }}</td>
                <td class="text-right">{{ number_format($item->total,2,',','.') }}</td>
            </tr>
                @php
                    $total = $total + $item->total;
                    $totaldpp = $totaldpp + $item->dpp;
                    $totalppn = $totalppn + $item->ppn;
                @endphp
            @endforeach 
            <tr>
                <td colspan="5" style="font-weight:bold">Total</td>
                <td class="text-right" style="font-weight:bold">{{ number_format($totaldpp,2,',','.') }}</td>
                <td class="text-right" style="font-weight:bold">{{ number_format($totalppn,2,',','.') }}</td>
                <td class="text-right" style="font-weight:bold">{{ number_format($total,2,',','.') }}</td>
            </tr>
        </table>
        @endif
    </body>

</html>