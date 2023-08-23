<html>

    <head>
        <title>Laporan Saldo Persediaan</title>
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
        table{
            border-collapse: collapse;
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
        <h4 style="text-align:center">LAPORAN SALDO PERSEDIAAN</h4>
        @if (count($data) > 0)
        <p style="margin-bottom: 3rem;text-align:center">Periode : {{ date_format(date_create($tgl_awal),'d/M/Y').' - '.date_format(date_create($tgl_akhir),'d/M/Y') }}</p>
       
        <table class="mytable" style="width:100%">
            <tr>
                <td class="tdhead">No</td>
                <td class="tdhead">Kode Akun</td>
                <td class="tdhead">Nama Akun</td>
                <td class="tdhead">Saldo Awal</td>
                <td class="tdhead">Debet</td>
                <td class="tdhead">Kredit</td>
                <td class="tdhead">Saldo</td>
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
                <td class="text-right">{{ number_format($item->saldo_awal,4,'.',',') }}</td>
                <td class="text-right">{{ number_format($item->debet,4,'.',',') }}</td>
                <td class="text-right">{{ number_format($item->kredit,4,'.',',') }}</td>
                <td class="text-right">{{ number_format($item->saldo,4,'.',',') }}</td>
            </tr>
                @php
                    $totalsaldoawal = $totalsaldoawal + $item->saldo_awal;
                    $totalsaldokredit = $totalsaldokredit + $item->kredit;
                    $totalsaldodebet = $totalsaldodebet + $item->debet;
                    $totalsaldo = $totalsaldo + $item->saldo;
                @endphp
            @endforeach
            <tr>
                <td colspan="3" style="font-weight:bold">Total</td>
                <td class="text-right" style="font-weight:bold">{{ number_format($totalsaldoawal,4,',','.') }}</td>
                <td class="text-right" style="font-weight:bold">{{ number_format($totalsaldodebet,4,',','.') }}</td>
                <td class="text-right" style="font-weight:bold">{{ number_format($totalsaldokredit,4,',','.') }}</td>
                <td class="text-right" style="font-weight:bold">{{ number_format($totalsaldo,4,',','.') }}</td>
            </tr>
        </table>
        @endif
    </body>

</html>