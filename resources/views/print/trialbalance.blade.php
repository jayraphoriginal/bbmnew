<html>

    <head>
        <title>Laporan Trial Balance</title>
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
        table{
            border-collapse: collapse;
        }
        .page_break { 
            page-break-before: always; 
        }
        .tdhead{
            font-weight: bold;
        }
        .text-right{
            text-align:right;
        }
    </style>

    <body>
        
        <h4 style="text-align:center">TRIAL BALANCE</h4>
        <h4 style="text-align:center">PT. BINTANG BETON MANDALA</h4></h4>
        <h5 style="margin-bottom: 3rem;text-align:center">Tahun : {{ $tahun }} Bulan : {{ $bulan }}</h5>
        @if (count($data) > 0)
        <table class="mytable" style="width:100%">
            <tr>
                <td class="tdhead">No</td>
                <td class="tdhead">Kode Akun</td>
                <td class="tdhead">Nama Akun</td>
                <td class="tdhead text-right">Saldo Awal</td>
                <td class="tdhead text-right">Debet</td>
                <td class="tdhead text-right">Kredit</td>
                <td class="tdhead text-right">Saldo</td>
            </tr>
            
            @php
                $totalsaldoawal = 0;
                $totalsaldodebet = 0;
                $totalsaldokredit = 0;
                $totalsaldo = 0;
            @endphp
            @foreach($data as $index => $item)
            <tr>
                <td>{{ ++$index }}</td>
                <td>{{ $item->kode_akun }}</td>
                <td>{{ $item->nama_akun }}</td>
                <td class="text-right">{{ number_format($item->saldo_awal,2,'.',',') }}</td>
                <td class="text-right">{{ number_format($item->debet,2,'.',',') }}</td>
                <td class="text-right">{{ number_format($item->kredit,2,'.',',') }}</td>
                <td class="text-right">{{ number_format($item->saldo_akhir,2,'.',',') }}</td>
            </tr>
                @php
                    $totalsaldoawal = $totalsaldoawal + $item->saldo_awal;
                    $totalsaldodebet = $totalsaldodebet + $item->debet;
                    $totalsaldokredit = $totalsaldokredit + $item->kredit;
                    $totalsaldo = $totalsaldo+ $item->saldo_akhir;
                @endphp
            @endforeach 
            <tr>
                <td colspan="3" style="font-weight:bold">Total</td>
                <td class="text-right" style="font-weight:bold">{{ number_format($totalsaldoawal,2,',','.') }}</td>
                <td class="text-right" style="font-weight:bold">{{ number_format($totalsaldodebet,2,',','.') }}</td>
                <td class="text-right" style="font-weight:bold">{{ number_format($totalsaldokredit,2,',','.') }}</td>
                <td class="text-right" style="font-weight:bold">{{ number_format($totalsaldo,2,',','.') }}</td>
            </tr>
        </table>
        @endif
    </body>

</html>