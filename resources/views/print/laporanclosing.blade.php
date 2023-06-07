<html>

    <head>
        <title>Laporan Jurnal Closing</title>
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
        <h4 style="text-align:center">LAPORAN JURNAL CLOSING</h4>
        @if (count($data) > 0)
        <p style="margin-bottom: 3rem;">Periode : {{ $tahun.' - '.$bulan }}</p>
       
        <table class="mytable" style="width:100%">
            <tr>
                <td class="tdhead">No</td>
                <td class="tdhead">Tanggal</td>
                <td class="tdhead">Kode Akun</td>
                <td class="tdhead">Nama Akun</td>
                <td class="tdhead">Keterangan</td>
                <td class="tdhead">Debet</td>
                <td class="tdhead">Kredit</td>
            </tr>
            
            @php
                $totalsaldodebet = 0;
                $totalsaldokredit = 0;
            @endphp
            @foreach($data as $index => $item)
            <tr>
                <td>{{ ++$index }}</td>
                <td>{{ date_format(date_create($item->tanggal),'d/M/Y') }}</td>
                <td>{{ $item->kode_akun }}</td>
                <td>{{ $item->nama_akun }}</td>
                <td>{{ $item->keterangan }}</td>
                <td class="text-right">{{ number_format($item->debet,2,'.',',') }}</td>
                <td class="text-right">{{ number_format($item->kredit,2,'.',',') }}</td>
            </tr>
                @php
                    $totalsaldodebet = $totalsaldodebet + $item->debet;
                    $totalsaldokredit = $totalsaldokredit + $item->kredit;
                @endphp
            @endforeach
            <tr>
                <td colspan="5" style="font-weight:bold">Total</td>
                <td class="text-right" style="font-weight:bold">{{ number_format($totalsaldodebet,2,',','.') }}</td>
                <td class="text-right" style="font-weight:bold">{{ number_format($totalsaldokredit,2,',','.') }}</td>
            </tr>
        </table>
        @endif
    </body>

</html>