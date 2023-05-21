<html>

    <head>
        <title>Laporan Laba Rugi</title>
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
        <p style="text-align:center;font-size:14px">Laporan Laba Rugi</p>
        <p style="text-align:center;font-size:14px">Tanggal : {{ $tgl_awal }} - {{ $tgl_akhir }}</p> 
        @if (count($data) > 0)
        <div class="mytable" style="width:100%;">
            <table style="width:100%">
                @php
                    $totalpendapatanusaha = 0;
                    $totalhpp = 0;
                    $totalbiayaops = 0;
                    $totalbiayapenjualan = 0;
                    $totalbiayaadm = 0;
                    $totalpendapatandiluarusaha = 0;
                    $labarugi=0;
                    $bebandiluarusaha = 0;
                @endphp
                <tr>
                    <td colspan="2" style="height: 3%;font-weight:bold">A. Pendapatan Usaha</td>
                </tr>
                @foreach($data as $index => $item)
                    @if($item->tipe=='A. Pendapatan Usaha')
                        <tr>
                            <td>{{ $item->nama_akun }}</td>
                            <td class="text-right">{{ number_format($item->saldo,0,',','.') }}</td>
                        </tr>
                        @php
                            $totalpendapatanusaha = $totalpendapatanusaha + $item->saldo;
                        @endphp
                    @endif
                @endforeach
                <tr>
                    <td style="height: 3%;font-weight:bold;vertical-align:top">Total Pendapatan Usaha</td>
                    <td class="text-right" style="height: 3%;font-weight:bold;vertical-align:top">{{ number_format($totalpendapatanusaha,0,',','.') }}</td>
                </tr>
                <tr>
                    <td colspan="2" style="height: 3%;font-weight:bold">B. Harga Pokok Penjualan</td>
                </tr>
                @foreach($data as $index => $item)
                    @if($item->tipe=='B. Harga Pokok Penjualan')
                        <tr>
                            <td>{{ $item->nama_akun }}</td>
                            <td class="text-right">{{ number_format($item->saldo,0,',','.') }}</td>
                        </tr>
                        @php
                            $totalhpp = $totalhpp + $item->saldo;
                        @endphp
                    @endif
                @endforeach 
                <tr>
                    <td style="height: 3%;font-weight:bold;vertical-align:top">Total Harga Pokok Penjualan</td>
                    <td class="text-right" style="height: 3%;font-weight:bold;vertical-align:top">{{ number_format($totalhpp,0,',','.') }}</td>
                </tr>
                <tr>
                    <td style="height: 3%;font-weight:bold;vertical-align:top">Total Laba Kotor</td>
                    <td class="text-right" style="height: 3%;font-weight:bold;vertical-align:top">{{ number_format($totalpendapatanusaha-$totalhpp,0,',','.') }}</td>
                </tr>
                <tr>
                    <td colspan="2" style="height: 3%;font-weight:bold">C. Biaya Operasional</td>
                </tr>
                <tr>
                    <td colspan="2" style="padding-left:20px;font-weight:bold">I. Biaya Penjualan</td>
                </tr>
                @foreach($data as $index => $item)
                    @if($item->tipe=='C. Biaya Operasional')
                        @if($item->tipe2=='I. Biaya Penjualan')
                            <tr>
                                <td style="padding-left:20px;">{{ $item->nama_akun }}</td>
                                <td class="text-right">{{ number_format($item->saldo,0,',','.') }}</td>
                            </tr>
                            @php
                                $totalbiayapenjualan = $totalbiayapenjualan + $item->saldo;
                                $totalbiayaops = $totalbiayaops + $item->saldo;
                            @endphp
                        @endif
                    @endif
                @endforeach 
                <tr>
                    <td style="font-weight:bold;vertical-align:top;padding-left:20px;">Total Biaya Penjualan</td>
                    <td class="text-right" style="height: 3%;font-weight:bold;vertical-align:top">{{ number_format($totalbiayapenjualan,0,',','.') }}</td>
                </tr>
                <tr>
                    <td colspan="2" style="padding-left:20px;font-weight:bold">II. Biaya Administrasi & Umum</td>
                </tr>
                @foreach($data as $index => $item)
                    @if($item->tipe=='C. Biaya Operasional')
                        @if($item->tipe2=='II. Biaya Administrasi & Umum')
                            <tr>
                                <td style="padding-left:20px;">{{ $item->nama_akun }}</td>
                                <td class="text-right">{{ number_format($item->saldo,0,',','.') }}</td>
                            </tr>
                            @php
                                $totalbiayaadm = $totalbiayaadm + $item->saldo;
                                $totalbiayaops = $totalbiayaops + $item->saldo;
                            @endphp
                        @endif
                    @endif
                @endforeach
                <tr>
                    <td style="font-weight:bold;vertical-align:top">Total Biaya Administrasi & Umum</td>
                    <td class="text-right" style="height: 3%;font-weight:bold;vertical-align:top">{{ number_format($totalbiayaadm,0,',','.') }}</td>
                </tr>
                <tr>
                    <td style="height: 3%;font-weight:bold;vertical-align:top">Total Biaya Operasional</td>
                    <td class="text-right" style="height: 3%;font-weight:bold;vertical-align:top">{{ number_format($totalbiayaops,0,',','.') }}</td>
                </tr>
                <tr>
                    <td style="height: 3%;font-weight:bold;vertical-align:top">Total Laba Operasional</td>
                    <td class="text-right" style="height: 3%;font-weight:bold;vertical-align:top">{{ number_format($totalpendapatanusaha-$totalhpp-$totalbiayaops,0,',','.') }}</td>
                </tr>
                <tr>
                    <td colspan="2" style="height: 3%;font-weight:bold">D. Pendapatan di Luar Usaha</td>
                </tr>
                @foreach($data as $index => $item)
                    @if($item->tipe=='D. Pendapatan di Luar Usaha')
                        <tr>
                            <td>{{ $item->nama_akun }}</td>
                            <td class="text-right">{{ number_format($item->saldo,0,',','.') }}</td>
                        </tr>
                        @php
                            $totalpendapatandiluarusaha = $totalpendapatandiluarusaha + $item->saldo;
                        @endphp
                    @endif
                @endforeach
                <tr>
                    <td style="height: 3%;font-weight:bold;vertical-align:top">Total Pendapatan Di Luar Usaha</td>
                    <td class="text-right" style="height: 3%;font-weight:bold;vertical-align:top">{{ number_format($totalpendapatandiluarusaha,0,',','.') }}</td>
                </tr>
                <tr>
                    <td colspan="2" style="height: 3%;font-weight:bold">E. Beban di Luar Usaha</td>
                </tr>
                @foreach($data as $index => $item)
                    @if($item->tipe=='E. Beban di Luar Usaha')
                        <tr>
                            <td>{{ $item->nama_akun }}</td>
                            <td class="text-right">{{ number_format($item->saldo,0,',','.') }}</td>
                        </tr>
                        @php
                            $bebandiluarusaha = $bebandiluarusaha + $item->saldo;
                        @endphp
                    @endif
                @endforeach
                <tr>
                    <td style="height: 3%;font-weight:bold;vertical-align:top">Total Beban Di Luar Usaha</td>
                    <td class="text-right" style="height: 3%;font-weight:bold;vertical-align:top">{{ number_format($bebandiluarusaha,0,',','.') }}</td>
                </tr>
                <tr>
                    <td style="height: 3%;font-weight:bold;vertical-align:top">Laba / Rugi</td>
                    <td class="text-right" style="height: 3%;font-weight:bold;vertical-align:top">{{ number_format($totalpendapatanusaha-$totalhpp-$totalbiayaops+$totalpendapatandiluarusaha-$bebandiluarusaha,0,',','.') }}</td>
                </tr>
            </table>
        </div>
        @endif
    </body>

</html>