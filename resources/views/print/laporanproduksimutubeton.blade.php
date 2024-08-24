<html>

    <head>
       <title>Laporan Produksi Customer</title>
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
        
        <h4 style="text-align:center">LAPORAN PRODUKSI MUTU BETON</h4>
        <p style="margin-bottom: 1rem;">Periode : {{ date_format(date_create($tgl_awal),'d/m/Y').' - '.date_format(date_create($tgl_akhir),'d/m/Y') }}</p>
        @if (count($data) > 0)
        <table class="mytable" style="width: 100%;">
            <tr>
                <td class="tdhead" rowspan="2">No</td>
                <td class="tdhead" rowspan="2">Mutu Beton</td>
                <td class="tdhead text-right" rowspan="2">Volume ( M<sup>3</sup> )</td>
                <td class="tdhead" colspan="6" style="text-align: center;" >Pengeluaran Material</td>
            </tr>
            <tr>
                <td class="tdhead text-right">Air Beton (L)</td>
                <td class="tdhead text-right">Batu Pecah 1/1 ( M<sup>3</sup> )</td>
                <td class="tdhead text-right">Batu Pecah 1/2 ( M<sup>3</sup> )</td>
                <td class="tdhead text-right">Batu Pecah 2/3 ( M<sup>3</sup> )</td>
                <td class="tdhead text-right">Pasir ( M<sup>3</sup> )</td>
                <td class="tdhead text-right">Semen ( Ton )</td>
            </tr>
            @php
                $totalair = 0;
                $totalbatu11 = 0;
                $totalbatu12 = 0;
                $totalbatu23 = 0;
                $totalpasir = 0;
                $totalsemen = 0;
                $totalkubik = 0;
                $row = 1;
            @endphp
            @foreach($data as $item)
            @php
                $isi = json_decode(json_encode($item), true);
            @endphp
            <tr>
                <td>{{ $row++ }}</td>
                @php
                    $kolom=1
                @endphp
                @foreach($isi as $td)
                    @if($kolom == 2)
                        <td class="text-right">{{ number_format($td,2,',','.') }}</td>
                    @elseif($kolom == 3)
                        <td class="text-right">{{ number_format($td,2,',','.') }}</td>
                    @elseif($kolom >= 4)
                        <td class="text-right">{{ number_format($td,4,',','.') }}</td>
                    @else
                        <td>{{ $td }}</td>
                    @endif
                    @php
                        if($kolom == 3){
                            $totalair = $totalair + $td;
                        }elseif ($kolom == 4){
                            $totalbatu11 = $totalbatu11 + $td;
                        }elseif ($kolom == 5){
                            $totalbatu12 = $totalbatu12 + $td;
                        }elseif ($kolom == 6){
                            $totalbatu23 = $totalbatu23 + $td;
                        }elseif ($kolom == 7){
                            $totalpasir = $totalpasir + $td;
                        }elseif ($kolom == 8){
                            $totalsemen = $totalsemen + $td;
                        }elseif( $kolom == 2){
                            $totalkubik = $totalkubik + $td;
                        }
                        $kolom = $kolom +1;
                    @endphp
                @endforeach
            </tr>
            @endforeach
            <tr>
                <td colspan="2">Total :</td>
                <td class="text-right" style="font-weight:bold">{{ number_format($totalkubik,2,',','.') }}</td>
                <td class="text-right" style="font-weight:bold">{{ number_format($totalair,4,',','.') }}</td>
                <td class="text-right" style="font-weight:bold">{{ number_format($totalbatu11,4,',','.') }}</td>
                <td class="text-right" style="font-weight:bold">{{ number_format($totalbatu12,4,',','.') }}</td>
                <td class="text-right" style="font-weight:bold">{{ number_format($totalbatu23,4,',','.') }}</td>
                <td class="text-right" style="font-weight:bold">{{ number_format($totalpasir,4,',','.') }}</td>
                <td class="text-right" style="font-weight:bold">{{ number_format($totalsemen,4,',','.') }}</td>
            </tr>
        </table>
        @endif
    </body>

</html>