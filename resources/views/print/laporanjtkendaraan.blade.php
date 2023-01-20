<html>

    <head>
        <title>LAPORAN JATUH TEMPO KENDARAAN</title>
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
            text-align: right;
        }
    </style>

    <body>
        
        <h4 style="text-align:center">LAPORAN JATUH TEMPO KENDARAAN</h4>
        <p>Per Tanggal : {{ Date('d/m/Y') }}</p>
        @if (count($data) > 0)
        <table class="mytable" style="width: 100%;">
            <tr>
                <td class="tdhead">No</td>
                <td class="tdhead">Nopol</td>
                <td class="tdhead">Driver</td>
                <td class="tdhead">Tgl. STNK</td>
                <td class="tdhead">Selisih STNK</td>
                <td class="tdhead">Tgl. KIR</td>
                <td class="tdhead">Selisih STNK</td>
                <td class="tdhead">Tgl. SIU</td>
                <td class="tdhead">Selisih SIU</td>
            </tr>
            
            @php
                $total= 0;
            @endphp
            @foreach($data as $index => $item)
            <tr>
                <td>{{ ++$index }}</td>
                <td>{{ $item->nopol }}</td>
                <td>{{ $item->nama_driver }}</td>
                <td class="text-center">{{ date_create($item->berlaku_sampai)->format('d/m/Y') }}</td>
                <td class="text-center">{{ number_format($item->jt_stnk,0,',','.').' Hari' }}</td>
                <td class="text-center">{{ date_create($item->berlaku_kir)->format('d/m/Y') }}</td>
                <td class="text-center">{{ number_format($item->jt_kir,0,',','.').' Hari' }}</td>
                <td class="text-center">{{ date_create($item->siu)->format('d/m/Y') }}</td>
                <td class="text-center">{{ number_format($item->jt_siu,0,',','.').' Hari' }}</td>
            </tr>
            @endforeach 
        </table>
        @endif
    </body>

</html>