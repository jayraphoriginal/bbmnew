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
        
        <h4 style="text-align:center">LAPORAN PRODUKSI CUSTOMER</h4>
        
        @if (count($datacustomer) > 0)
        <table class="mytable" style="width: 100%;">
            <tr>
                <td class="tdhead" rowspan="2">Tanggal</td>
                <td class="tdhead" rowspan="2">Customer</td>
                <td class="tdhead" rowspan="2">Lokasi</td>
                <td class="tdhead text-right" rowspan="2">Produksi</td>
                <td class="tdhead" rowspan="2">Kode Mutu</td>
                <td class="tdhead" colspan="5" style="text-align: center;" >Pengeluaran Material</td>
            </tr>
            <tr>
                <td class="tdhead text-right">Batu Pecah 1/1</td>
                <td class="tdhead text-right">Batu Pecah 1/2</td>
                <td class="tdhead text-right">Batu Pecah 2/3</td>
                <td class="tdhead text-right">Pasir</td>
                <td class="tdhead text-right">Semen</td>
            </tr>
            @php
                $totalbatu11 = 0;
                $totalbatu12 = 0;
                $totalbatu23 = 0;
                $totalpasir = 0;
                $totalsemen = 0;
                $totalkubik = 0;
            @endphp
            @foreach($datacustomer as $item)
            @php
                $isi = json_decode(json_encode($item), true);
            @endphp
            <tr>
                @php
                    $kolom=1
                @endphp
                @foreach($isi as $td)
                    @if($kolom ==1)
                        <td style="width:7%">{{ $td }}</td>
                    @elseif($kolom == 4)
                        <td class="text-right">{{ number_format($td,2,',','.') }} M<sup>3</sup></td>
                    @elseif($kolom >= 6)
                        <td class="text-right">{{ number_format($td,4,',','.') }}</td>
                    @else
                        <td>{{ $td }}</td>
                    @endif
                    @php
                        if ($kolom == 6){
                            $totalbatu11 = $totalbatu11 + $td;
                        }elseif ($kolom == 7){
                            $totalbatu12 = $totalbatu12 + $td;
                        }elseif ($kolom == 8){
                            $totalbatu23 = $totalbatu23 + $td;
                        }elseif ($kolom == 9){
                            $totalpasir = $totalpasir + $td;
                        }elseif ($kolom == 10){
                            $totalsemen = $totalsemen + $td;
                        }elseif( $kolom == 4){
                            $totalkubik = $totalkubik + $td;
                        }
                        $kolom = $kolom +1;
                    @endphp
                @endforeach
            </tr>
            @endforeach
            <tr>
                <td colspan="3">Total :</td>
                <td class="text-right" style="font-weight:bold">{{ number_format($totalkubik,2,',','.') }}</td>
                <td></td>
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