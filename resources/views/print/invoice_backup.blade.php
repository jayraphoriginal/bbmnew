<html>

    <head>
        <style>
            .mytable>tbody>tr>td, .mytable>tbody>tr>th, .mytable>tfoot>tr>td, .mytable>tfoot>tr>th, .mytable>thead>tr>th {
            padding: 5px;
            vertical-align: middle;
            border:1px solid;
            margin:0;
            }
            *{
                font-size:14px
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
                text-align:center;
            }
            .captionleft{
                text-align:left;
            }
            .captionright{
                text-align:right;
            }  
        </style>
        <title>{{ $data[0]->noinvoice }}</title>
    </head>

    <body>
        <div style="padding:10px;border:solid 1px;margin-bottom:2rem">
        <p style="margin-top:1em; text-align:center; text-decoration:underline; font-size:18px; font-weight:bold">FAKTUR INVOICE</p>
        <p style="text-align:center;font-size:18px; font-weight:bold; margin-bottom:2.5rem">FAKTUR TAGIHAN</p>

        <table style="float:right">
            <tr>
                <td class="captioncenter">{{ "No Invoice. ".$data[0]->noinvoice }}</td>
            </tr>
        </table>

        <p>Kepada </p>
        @if($data[0]->tipe == 'Retail')
        <p style="font-weight:bold;">{{ $data[0]->nama_pemilik }}</p>
        @else
        <p style="font-weight:bold;">{{ $data[0]->nama_customer }}</p>
        @endif
        <p>di - Tempat</p>

        <table class="mytable" style="margin-top:2em; margin-bottom:1em;width:100%">
            <tr>
                <td class="captioncenter">No</td>
                <td class="captioncenter">Uraian</td>
                <td class="captionright">Satuan</td>
                <td class="captionright">Harga</td>
                <td class="captionright">Jumlah</td>
            </tr>
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
                            <td class="captionright" style="width:15%">{{ number_format($jual->jumlah,2,".",",").' '.$jual->satuan }}</td>
                            <td class="captionright" style="width:15%">{{ number_format($jual->harga_intax/(1+($jual->pajak/100)),0,".",",") }}</td>
                            <td class="captionright" style="width:15%">{{ number_format($jual->jumlah * ($jual->harga_intax/(1+($jual->pajak/100))),0,".",",") }}</td>
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
                    <td class="captionright">{{ number_format($dpp,0,".",",") }}</td>
                </tr>
                <tr>
                    <td colspan=4 class="captionleft">PPN {{ number_format($data[0]->pajak,0,'.'.',').'%' }}</td>
                    <td class="captionright">{{ number_format($ppn,0,".",",") }}</td>
                </tr>
                @if ($dp > 0)
                <tr>
                    <td colspan=4 class="captionleft">DP</td>
                    <td class="captionright">{{ number_format($dp,0,".",",") }}</td>
                </tr>
                @endif
                <tr>
                    <td colspan=4 class="captionleft">Total</td>
                    <td class="captionright">{{ number_format($data[0]->total,0,".",",") }}</td>
                </tr>
                
                <tr>
                    <td colspan="5" style="font-size:16px; font-weight: bold;">{{ ucwords($terbilang).' Rupiah' }}</td>
                </tr>
            </tfoot>
        </table>
        </div>
        <table style="float:left;width:75%">
            <tr>
                <td style="height:1em;text-align:left; width:30%">Pembayaran di Transfer Ke</td>
            </tr>
            <tr>
                <td style="height:1em;text-align:left; font-weight:bold; width:30%">Rekening {{ $data[0]->nama_bank }}</td>
            </tr>
            <tr>
                <td style="height:1em;text-align:left; width:30%">{{ $data[0]->norek }}</td>
            </tr>
            <tr>
                <td style="height:1em;text-align:left; width:30%">{{ $data[0]->atas_nama }}</td>
            </tr>
        </table>
        <table style="float:right;width:25%">
            <tr>
                <td style="height:2em;text-align:left; width:30%">Palembang, {{ date_format(date_create($data[0]->tgl_cetak), 'd M Y') }}</td>
            </tr>
            <tr>
                @if($data[0]->tipe <> 'Retail')
                <td style="height:2em;text-align:left; font-weight:bold; width:30%">PT. Bintang Beton Mandala</td>
                @endif
            </tr>
            <tr>
                @if($data[0]->tipe <> 'Retail')
                    <td style="height:14em;text-align:left; width:30%">{{ $data[0]->tanda_tangan }}</td>
                @else
                    <td style="height:14em;text-align:left; width:30%">Karno</td>
                @endif
            </tr>
        </table>
    </body>

</html>