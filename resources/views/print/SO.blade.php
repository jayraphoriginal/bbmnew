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

        <h1>{{ $data[0]->nama_customer }} </h1>
        <p> {{ $data[0]->alamat }}</p>
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

        <p class="tglkanan">Tanggal Order : {{ date_format(date_create($data[0]->tgl_so),'d M Y') }}</p>

        <h2 style="margin-top:1em; text-align:center; text-decoration:underline">Purchase Order</h2>
        <p style="text-align:center">{{ $data[0]->noso }}</p>

        <p>Kepada Yang Terhormat Bapak / Ibu</p>
        <p style="font-weight:bold;">PT. Bintang Beton Mandala</p>
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

        <table style="float:right;">
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
                    <td class="captioncenter">Mutu Beton</td>
                    <td class="captionright">Jumlah</td>
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
                @foreach($data as $jual)
                    @php
                        $totaldpp += $jual->jumlah * $jual->harga_intax/((100+$jual->pajak)/100);
                        $total += $jual->jumlah * $jual->harga_intax;
                    @endphp
                    <tr>
                        <td class="captioncenter">{{ $i++ }}</td>
                        <td class="captioncenter">{{ $jual->kode_mutu }}</td>
                        <td class="captionright">{{ number_format($jual->jumlah,2,".",",") }}</td>
                        <td class="captionright">{{ number_format($jual->harga_intax/((100+$jual->pajak)/100),2,".",",") }}</td>
                        <td class="captionright">{{ number_format($jual->jumlah * $jual->harga_intax/((100+$jual->pajak)/100),2,".",",") }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan=4 class="captionleft">DPP</td>
                    <td class="captionright">{{ number_format($totaldpp,2,".",",") }}</td>
                </tr>
                <tr>
                    <td colspan=4 class="captionleft">Total Biaya Tambahan</td>
                    <td class="captionright">{{ number_format($biayatambahan,2,".",",") }}</td>
                </tr>
                <tr>
                    <td colspan=4 class="captionleft">Concrete Pump</td>
                    <td class="captionright">{{ number_format($concretepump,2,".",",") }}</td>
                </tr>
                <tr>
                    <td colspan=4 class="captionleft">Total Penjualan</td>
                    <td class="captionright">{{ number_format($totaldpp,2,".",",") }}</td>
                </tr>
                <tr>
                    <td colspan=4 class="captionleft">PPN {{ $data[0]->pajak.'%' }}</td>
                    <td class="captionright">{{ number_format($totaldpp*($data[0]->pajak/100),2,".",",") }}</td>
                </tr>
                <tr>
                    <td colspan=4 class="captionleft">Grandtotal</td>
                    <td class="captionright">{{ number_format($total+$concretepump+$biayatambahan,2,".",",") }}</td>
                </tr>
            </tfoot>
        </table>

        <p style="margin:2rem 0 1rem 0">Keterangan</p>
        <table class="table table-sm table-bordered" style="font-size:13px; margin-bottom:4rem">
            <tr>
                <td rowspan=2 class="captioncenter">No</td>
                <td rowspan=2 class="captioncenter">Mutu Beton</td>
                <td colspan=2 class="captioncenter">Periode Pengecoran</td>
                <td rowspan=2 class="captioncenter">Lama Pengecoran</td>
                <td rowspan=2 class="captioncenter">Lokasi</td>
            </tr>
            <tr>
                <td style="text-align:center">Dari</td>
                <td style="text-align:center">Sampai</td>
            </tr>
            <tbody>
                @php 
                    $i = 1;
                @endphp
                @foreach($data as $jual)
                    @php
                        $diff=date_diff(date_create($jual->tgl_awal),date_create($jual->tgl_akhir));
                    @endphp
                    <tr>
                        <td class="captionleft">{{ $i++ }}</td>
                        <td class="captionleft">{{ $jual->kode_mutu }}</td>
                        <td class="captionleft">{{ date_format(date_create($jual->tgl_awal),'d M Y') }}</td>
                        <td class="captionleft">{{ date_format(date_create($jual->tgl_akhir),'d M Y') }}</td>
                        <td class="captionright">{{ $diff->format("%a") + 1 }} Hari</td>
                        <td class="captionleft">{{ $jual->tujuan }}</td>
                    </tr>
                @endforeach
            </tbody>

        </table>

        <p style="text-align:right">Palembang, {{ date_format(now(), 'd M Y') }}</p>

        <table style="width:100%">
            <tr>
                <td style="height:8em;text-align:center; width:30%">Customer</td>
                <td style="height:8em;width:55%"></td>
                <td style="height:8em;text-align:center">PT. Bintang Beton Mandala</td>
            </tr>

            <tr>
                <td class="captioncenter" style="width:30%">{{$data[0]->nama_customer}} </td>
                <td style="width:55%"></td>
                <td class="captioncenter">{{$data[0]->marketing}}</td>
            </tr>
        </table>

    </body>

</html>