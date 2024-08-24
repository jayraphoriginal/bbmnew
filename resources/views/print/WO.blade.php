<html>

    <head>
        <style>
            *{
                font-size:13px;
            }
            .mytable>tbody>tr>td, .mytable>tbody>tr>th, .mytable>tfoot>tr>td, .mytable>tfoot>tr>th, .mytable>thead>tr>td, .mytable>thead>tr>th {
                padding: 5px;
                vertical-align: middle;
                margin:0;
                border:1px solid;
            }
            table{
                border-collapse: collapse;
            }

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
                width:5em;
            }
            .kl2{
                width:12em;
                white-space: nowrap;
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
        <title>{{ $data[0]->noso }}</title>
    </head>

    <body>

        <h2 style="margin-top:2em; text-align:center; text-decoration:underline">WORK ORDER</h2>
         <h2 style="text-align:center; text-decoration:underline">PRODUKSI BETON</h2>

        <p style="margin-top:2rem; font-weight:bold;">{{ $data[0]->nama_customer }}</p>
        <p>{{ $data[0]->alamat }}</p>
        <table >
            <tr>
                <td class="kl1">Telp</td>
                <td>{{ $data[0]->notelp }}</td>
            </tr>
            <tr>
                <td class="kl1">Fax</td>
                <td>{{ $data[0]->nofax }}</td>
            </tr>
        </table>

        <table style="float:right;">
            <tr>
                <td class="kl2">Tanggal (WO)</td>
                <td> : </td>
                <td>{{ date_format(date_create($tglprint),'d M Y') }}</td>
            </tr>
            <tr>
                <td class="kl2">No. Purchase Order</td>
                <td> : </td>
                <td>{{ $data[0]->noso }}</td>
            </tr>
            <tr>
                <td class="kl2">Tanggal Order</td>
                <td> : </td>
                <td>{{ date_format(date_create($data[0]->tgl_so),'d M Y') }}</td>
            </tr>
        </table>

       <table class="mytable" style="margin-top:5rem; font-size:13px; margin-bottom:4rem;width:100%">
            <tr>
                <td class="captioncenter">No</td>
                <td class="captioncenter">Mutu Beton</td>
                <td class="captioncenter">Volume</td>
                <td class="captioncenter">Lama Pengecoran</td>
                <td class="captioncenter">Lokasi</td>
            </tr>
            <tbody>
                @php 
                    $i = 1;
                    $total = 0;
                @endphp
                @foreach($data as $jual)
                    @php
                        $diff=date_diff(date_create($jual->tgl_awal),date_create($jual->tgl_akhir));
                        $total = $total + $jual->jumlah;
                    @endphp
                    <tr>
                        <td class="captionleft">{{ $i++ }}</td>
                        <td class="captionleft">{{ $jual->deskripsi }}</td>
                        <td class="captionright">{{ number_format($jual->jumlah,2,".",",") }}</td>
                        <td class="captionright">{{ $diff->format("%a") + 1 }} Hari</td>
                        <td class="captionleft">{{ $jual->tujuan }}</td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="2" class="captionleft">Total Volume</td>
                    <td class="captionright">{{ number_format($total,2,".",",") }}</td>
                    <td colspan="2" class="captionleft"></td>
                </tr>
            </tbody>

        </table>

        @if(count($concretepump) > 0)
        <table class="mytable" style="margin-top:3rem; font-size:13px; margin-bottom:4rem;width:100%">
            <tr>
                <td class="captioncenter">No</td>
                <td class="captioncenter">Concrete Pump</td>
                <td class="captioncenter">Operator CP</td>
                <td class="captioncenter">Tanggal</td>
                <td class="captioncenter">Lokasi</td>
                <td class="captioncenter">Jarak</td>
            </tr>
            <tbody>
                @php 
                    $i = 1;
                @endphp
                @foreach($concretepump as $pompa)
                    <tr>
                        <td class="captionleft">{{ $i++ }}</td>
                        <td class="captionleft">{{ $pompa->nopol }}</td>
                        <td class="captionleft">{{ $pompa->nama_driver }}</td>
                        <td class="captionleft">{{ date_format(date_create($pompa->tanggal),'d M Y') }}</td>
                        <td class="captionleft">{{ $pompa->tujuan }}</td>
                        <td class="captionright">{{ number_format($pompa->estimasi_jarak,2,".",",") }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        @endif

        <p style="text-align:right">Palembang, {{ date_format(now(), 'd M Y') }}</p>

        <table style="width:100%">
            <tr>
                <td style="height:8em;text-align:center; width:30%">Operator</td>
                <td style="height:8em;width:55%"></td>
                <td style="height:8em;text-align:center; width:30%">Dibuat Oleh</td>
            </tr>

            <tr>
                <td class="captioncenter" style="width:30%; border-bottom: 1pt solid black;"></td>
                <td style="width:55%"></td>
                <td class="captioncenter" style="width:30%; border-bottom: 1pt solid black;"></td>
            </tr>
        </table>

    </body>

</html>