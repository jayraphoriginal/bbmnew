<html>

    <head>
        <title>Saldo Kas Bank</title>
    </head>

    <style>
        .mytable>tbody>tr>td, .mytable>tbody>tr>th, .mytable>tfoot>tr>td, .mytable>tfoot>tr>th, .mytable>thead>tr>td, .mytable>thead>tr>th {
            padding: 5px;
            vertical-align: middle;
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
        <h4 style="text-align:center">PT. BINTANG BETON MANDALA</h4></h4>
        @if (count($data) > 0)
        <h4 style="text-align:center">Saldo Kas Bank</h4>  
        <h5 style="margin-bottom: 3rem;text-align:center">Periode : {{ date_format(date_create($tgl_awal),'d/M/Y').' - '.date_format(date_create($tgl_akhir),'d/M/Y') }}</h5>
       
        <table class="mytable">
            <tr>
                <td class="tdhead">No</td>
                <td class="tdhead">Tanggal</td>
                <td class="tdhead">Keterangan</td>
                <td class="tdhead">Debet</td>
                <td class="tdhead">Kredit</td>
                <td class="tdhead">Saldo</td>
            </tr>
            <tr>
                <td>1</td>
                <td></td>
                <td>Saldo Awal</td>
                <td></td>
                <td></td>
                <td>{{ $saldoawal[0]->debet }}</td>
            </tr>
            
            @php
                $totalsaldodebet = 0;
                $totalsaldokredit = 0;
                $totalsaldo = 0;
                $saldoawal = $saldoawal[0]->debet;
            @endphp
            @foreach($data as $index => $item)
            <tr>
                <td>{{ $index+2 }}</td>
                <td>{{ date_format(date_create($item->tanggal_transaksi),'d/M/Y') }}</td>
                <td>{{ $item->keterangan }}</td>
                <td class="text-right">{{ number_format($item->debet,2,'.',',') }}</td>
                <td class="text-right">{{ number_format($item->kredit,2,'.',',') }}</td>
                <td class="text-right">{{ number_format($saldoawal - ($item->debet - $item->kredit),2,'.',',') }}</td>
            </tr>
                @php
                    $totalsaldodebet = $totalsaldodebet + $item->debet;
                    $totalsaldokredit = $totalsaldokredit + $item->kredit;
                    $saldoawal = $saldoawal - ($item->debet - $item->kredit);
                    $totalsaldo = $totalsaldo + $saldoawal - ($item->debet - $item->kredit);
                @endphp
            @endforeach 
            <tr>
                <td colspan="3" style="font-weight:bold">Total</td>
                <td class="text-right" style="font-weight:bold">{{ number_format($totalsaldodebet,2,',','.') }}</td>
                <td class="text-right" style="font-weight:bold">{{ number_format($totalsaldokredit,2,',','.') }}</td>
                <td class="text-right" style="font-weight:bold">{{ number_format($saldoawal,2,',','.') }}</td>
            </tr>
        </table>
        @endif
    </body>

</html>