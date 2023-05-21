<html>

    <head>
        <title>Laporan Neraca</title>
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
        <p style="text-align:center;font-size:14px;font-weight:bold;">PT. BINTANG BETON MANDALA</p>
        <p style="text-align:center;font-size:14px">Neraca</p>
        <p style="text-align:center;font-size:14px">Per Tanggal : {{ $tanggal }}</p> 
        @if (count($data) > 0)
        <table class="mytable" style="width:100%;">
            <tr>
                <td style="width:49%;vertical-align:top;height:80%;">
                    <table style="width:100%">
                        @php
                            $totalaktiva = 0;
                            $totalaktivalancar = 0;
                            $totalaktivatetap = 0;
                        @endphp
                        <tr>
                            <td colspan="2" style="height: 5%;font-weight:bold">A. Aktiva Lancar</td>
                        </tr>
                        @foreach($data as $index => $item)
                            @if($item->level1=='AKTIVA')
                                @if($item->level2=='A. Aktiva Lancar')
                                <tr>
                                    <td>{{ $item->nama_akun }}</td>
                                    <td class="text-right">{{ number_format($item->saldo,0,',','.') }}</td>
                                </tr>
                                @php
                                    $totalaktiva = $totalaktiva + $item->saldo;
                                    $totalaktivalancar = $totalaktivalancar + $item->saldo; 
                                @endphp
                                @endif 
                            @endif
                        @endforeach
                        <tr>
                            <td style="height: 5%;font-weight:bold;vertical-align:top">Total Aktiva Lancar</td>
                            <td class="text-right" style="height: 5%;font-weight:bold;vertical-align:top">{{ number_format($totalaktivalancar,0,',','.') }}</td>
                        </tr>
                        <tr>
                            <td colspan="2" style="height: 5%;font-weight:bold">B. Aktiva Tetap</td>
                        </tr>
                        @foreach($data as $index => $item)
                            @if($item->level1=='AKTIVA')
                                @if($item->level2=='B. Aktiva Tetap')
                                <tr>
                                    <td>{{ $item->nama_akun }}</td>
                                    <td class="text-right">{{ number_format($item->saldo,0,',','.') }}</td>
                                </tr>
                                @php
                                    $totalaktivatetap = $totalaktivatetap + $item->saldo;
                                    $totalaktiva = $totalaktiva + $item->saldo;
                                @endphp
                                @endif
                            @endif
                        @endforeach 
                        <tr>
                            <td style="height: 5%;font-weight:bold;vertical-align:top">Total Aktiva Tetap</td>
                            <td class="text-right" style="height: 5%;font-weight:bold;vertical-align:top">{{ number_format($totalaktivatetap,0,',','.') }}</td>
                        </tr>
                    </table>
                </td>
                <td style="width:49%;vertical-align:top;height:80%">
                    <table style="width:100%">
                        @php
                            $totalpassiva = 0;
                            $totalhutang = 0;
                            $totalmodal = 0;
                        @endphp
                        <tr>
                            <td colspan="2" style="height: 5%;font-weight:bold">A. Hutang</td>
                        </tr>
                        @foreach($data as $index => $item)
                            @if($item->level1=='PASSIVA')
                                @if($item->level2=='A. Hutang')
                                <tr>
                                    <td>{{ $item->nama_akun }}</td>
                                    <td class="text-right">{{ number_format($item->saldo,0,',','.') }}</td>
                                </tr>
                                @php
                                    $totalpassiva = $totalpassiva + $item->saldo;
                                    $totalhutang = $totalhutang + $item->saldo; 
                                @endphp
                                @endif 
                            @endif
                        @endforeach
                        <tr>
                            <td style="height: 5%;font-weight:bold;vertical-align:top">Total Hutang</td>
                            <td class="text-right" style="height: 5%;font-weight:bold;vertical-align:top">{{ number_format($totalhutang,0,',','.') }}</td>
                        </tr>
                        <tr>
                            <td colspan="2" style="height: 5%;font-weight:bold">B. Ekuitas</td>
                        </tr>
                        @foreach($data as $index => $item)
                            @if($item->level1=='PASSIVA')
                                @if($item->level2=='B. Ekuitas')
                                <tr>
                                    <td>{{ $item->nama_akun }}</td>
                                    <td class="text-right">{{ number_format($item->saldo,0,',','.') }}</td>
                                </tr>
                                @php
                                    $totalmodal = $totalmodal + $item->saldo;
                                    $totalpassiva = $totalpassiva + $item->saldo;
                                @endphp
                                @endif
                            @endif
                        @endforeach 
                        <tr>
                            <td style="height: 5%;font-weight:bold;vertical-align:top">Total Modal</td>
                            <td class="text-right" style="height: 5%;font-weight:bold;vertical-align:top">{{ number_format($totalmodal,0,',','.') }}</td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td class="text-right" style="font-weight:bold">
                    Total Aktiva : {{ number_format($totalaktiva,0,',','.') }}
                </td>
                <td class="text-right" style="font-weight:bold">
                    Total Passiva : {{ number_format($totalpassiva,0,',','.') }}
                </td>
            </tr>
        </table>
        @endif
    </body>

</html>