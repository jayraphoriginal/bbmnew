<html>

    <head>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <style>
            *{
                font-size:13px;
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
                width:5em
            }
            .kl2{
                width:10em
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
        <title>SO Sewa</title>
    </head>


    <body>

        <h1>PT. Bintang Beton Mandala</h1>
        <p>Jl. Soekarno Hatta No. 1C RT.006 RW 009 Siring Agung Ilir Barat 1 Palembang</p>
        <table>
            <tr>
                <td class="kl1">Telp</td>
                <td>+62711 - 418331</td>
            </tr>
            <tr>
                <td class="kl1">Fax</td>
                <td>+62711 - 418525</td>
            </tr>
            <tr>
                <td class="kl1">Email</td>
                <td>bintangbetonmandala@gmail.com</td>
            </tr>
        </table>
        @if (count($data) > 0)
        <p class="tglkanan">Tanggal Order : {{ date_format(date_create($data[0]->tgl_so),'d M Y') }}</p>

        <h2 style="margin-top:1em; text-align:center; text-decoration:underline">Sales Order</h2>
        <p style="text-align:center">{{ $data[0]->noso }}</p>

        <p>Kepada Yang Terhormat Bapak / Ibu</p>
        <p style="font-weight:bold;">{{ $data[0]->nama_customer }}</p>
        <p>{{ $data[0]->alamat }}</p>
        <table>
            <tr>
                <td class="kl1">Telp</td>
                <td>{{ $data[0]->notelp }}</td>
            </tr>
            <tr>
                <td class="kl1">Fax</td>
                <td>{{ $data[0]->nofax }}</td>
            </tr>
        </table>

        <table style="float:right">
            <tr>
                <td class="kl2">Pembayaran</td>
                <td> : </td>
                <td>{{ $data[0]->pembayaran }}</td>
            </tr>
            <tr>
                <td class="kl2">Jenis Pembayaran</td>
                <td> : </td>
                <td>{{ $data[0]->jenis_pembayaran }}</td>
            </tr>
            <tr>
                <td class="kl2">Tgl Jatuh Tempo</td>
                <td> : </td>
                <td>{{ date_format(date_create($data[0]->jatuh_tempo),'d M Y') }}<</td>
            </tr>
        </table>

        <table class="table table-sm table-bordered" style="margin-top:7em; margin-bottom:1em">
            <thead>
                <tr>
                    <td class="captioncenter">No</td>
                    <td class="captioncenter">Nama alat</td>
                    <td class="captionright">Lama</td>
                    <td class="captionright">Periode</td>
                    <td class="captionright">Harga DPP</td>
                    <td class="captionright">Sub Total</td>
                </tr>
            </thead>
            <tbody>
                @php 
                    $i = 1;
                    $total = 0;
                    $totaldpp = 0;
                @endphp
                @foreach($data as $sewa)
                    @php
                        $totaldpp += $sewa->lama * $sewa->harga_intax/((100+$sewa->pajak)/100);
                        $total += $sewa->lama * $sewa->harga_intax;
                    @endphp
                    <tr>
                        <td class="captioncenter">{{ $i++ }}</td>
                        <td class="captioncenter">{{ $sewa->nama_item }}</td>
                        <td class="captionright">{{ number_format($sewa->lama,2,".",",") }}</td>
                        <td class="captioncenter">{{ $sewa->satuan }}</td>
                        <td class="captionright">{{ number_format($sewa->harga_intax/((100+$sewa->pajak)/100),2,".",",") }}</td>
                        <td class="captionright">{{ number_format($sewa->lama * $sewa->harga_intax/((100+$sewa->pajak)/100),2,".",",") }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan=5 class="captionleft">DPP</td>
                    <td class="captionright">{{ number_format($totaldpp,2,".",",") }}</td>
                </tr>
                <tr>
                    <td colspan=5 class="captionleft">Total Penyewaan</td>
                    <td class="captionright">{{ number_format($totaldpp,2,".",",") }}</td>
                </tr>
                <tr>
                    <td colspan=5 class="captionleft">PPN {{ $data[0]->pajak.'%' }}</td>
                    <td class="captionright">{{ number_format($totaldpp*($data[0]->pajak/100),2,".",",") }}</td>
                </tr>
                <tr>
                    <td colspan=5 class="captionleft">Grandtotal</td>
                    <td class="captionright">{{ number_format($total,2,".",",") }}</td>
                </tr>
            </tfoot>
        </table>

        <p style="text-align:right">Palembang, {{ date_format(now(), 'd M Y') }}</p>

       
        <table style="width:100%">
            <tr>
                <td style="height:8em;text-align:center; width:30%">Marketing</td>
                <td style="height:8em;width:55%"></td>
                <td style="height:8em;text-align:center">Customer</td>
            </tr>

            <tr>
                <td class="captioncenter" style="width:30%">{{$data[0]->marketing}}</td>
                <td style="width:55%"></td>
                <td class="captioncenter">{{$data[0]->nama_customer}}</td>
            </tr>
        </table>
        @endif
    </body>

</html>