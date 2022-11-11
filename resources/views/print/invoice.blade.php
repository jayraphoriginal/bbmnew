<html>

    <head>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <style>
            *{
                font-size:10px;
            }
            table{margin:0rem}
            @page{
                margin: 0.1in 0.3in 0.2in 0.3in;
            }
            body{
                margin:0;
            }
            p{
                margin:0;
            }
            .kl1{
                width:5em
            }
            .kl2{
                width:8em
            }
            .tglkanan{
                float:right;
            }
            .captioncenter{
                font-weight:bold;
                text-align:center;
            }
            .captionleft{
                font-weight:bold;
                text-align:left;
            }
            .captionright{
                font-weight:bold;
                text-align:right;
            }  
        </style>
        <title>{{ $data[0]->noinvoice }}</title>
    </head>

    <body>
        <h4 style="margin-top:1em; text-align:center; text-decoration:underline">FAKTUR INVOICE</h4>
        <h4 style="text-align:center">FAKTUR TAGIHAN</h4>

        <table style="float:right">
            <tr>
                <td class="captioncenter">{{ "No Invoice. ".$data[0]->noinvoice }}</td>
            </tr>
        </table>

        <p>Kepada </p>
        <p style="font-weight:bold;">{{ $data[0]->nama_customer }}</p>
        <p>di - Tempat</p>

        <table class="table table-sm table-bordered" style="margin-top:1.5em; margin-bottom:1em">
            <thead>
                <tr>
                    <td class="captioncenter">No</td>
                    <td class="captioncenter">Uraian</td>
                    <td class="captionright">Satuan</td>
                    <td class="captionright">Harga</td>
                    <td class="captionright">Jumlah</td>
                </tr>
            </thead>
            <tbody>
                @php 
                    $i = 1;
                    $totalall = 0;
                    $dpp = 0;
                    $ppn = 0;
                @endphp
                @foreach ($data as $jual)
                        <tr>
                            <td class="captioncenter" style="width:5%">{{ $i++ }}</td>
                            <td class="captionleft">{{ $jual->uraian }}</td>
                            <td class="captionright" style="width:10%">{{ number_format($jual->jumlah,2,".",",").' '.$jual->satuan }}</td>
                            <td class="captionright" style="width:15%">{{ number_format($jual->harga_intax/(1+($jual->pajak/100)),2,".",",") }}</td>
                            <td class="captionright" style="width:15%">{{ number_format($jual->jumlah * $jual->harga_intax/(1+($jual->pajak/100)),2,".",",") }}</td>
                        </tr>
                        @php 
                            $totalall = $totalall + $jual->jumlah * $jual->harga_intax;
                        @endphp
                @endforeach
                @php
                    $dpp = $totalall /(1+($jual->pajak/100));
                    $ppn = $totalall - $dpp;
                @endphp
            </tbody>
            <tfoot>
                <tr>
                    <td colspan=4 class="captionleft">DPP</td>
                    <td class="captionright">{{ number_format($dpp,2,".",",") }}</td>
                </tr>
                <tr>
                    <td colspan=4 class="captionleft">PPN {{ number_format($data[0]->pajak,0,'.'.',').'%' }}</td>
                    <td class="captionright">{{ number_format($ppn,2,".",",") }}</td>
                </tr>
                @if ($dp > 0)
                <tr>
                    <td colspan=4 class="captionleft">DP</td>
                    <td class="captionright">{{ number_format($dp,2,".",",") }}</td>
                </tr>
                @endif
                <tr>
                    <td colspan=4 class="captionleft">Total</td>
                    <td class="captionright">{{ number_format($data[0]->total,2,".",",") }}</td>
                </tr>
                
                <tr>
                    <td colspan="5" style="font-size:16px; font-weight: bold;">{{ ucwords($terbilang).' Rupiah' }}</td>
                </tr>
            </tfoot>
        </table>
        <table style="float:left;width:45%">
            <tr>
                <td style="height:1em;text-align:left; width:30%">Pembayaran di Transfer Ke</td>
            </tr>
            <tr>
                <td style="height:1em;text-align:left; font-weight:bold; width:30%">Rekening {{ $data[0]->nama_bank }}</td>
            </tr>
            <tr>
                <td style="height:1em;text-align:left; width:30%" style="width:30%">{{ $data[0]->norek }}</td>
            </tr>
            <tr>
                <td style="height:1em;text-align:left; width:30%" style="width:30%">{{ $data[0]->atas_nama }}</td>
            </tr>
        </table>
        <table style="float:right;width:45%">
            <tr>
                <td style="height:2em;text-align:right; width:30%">Palembang, {{ date_format(date_create($data[0]->tgl_cetak), 'd M Y') }}</td>
            </tr>
            <tr>
                <td style="height:2em;text-align:right; font-weight:bold; width:30%">PT. Bintang Beton Mandala</td>
            </tr>
            <tr>
                <td style="height:8em;text-align:right; width:30%" style="width:30%">{{ $data[0]->tanda_tangan }}</td>
            </tr>
        </table>
    </body>

</html>