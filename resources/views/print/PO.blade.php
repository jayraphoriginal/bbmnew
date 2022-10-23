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
        <title>PURCHASE ORDER</title>
    </head>

    <body>
        <h4 style="margin-top:1em; text-align:center; text-decoration:underline">PURCHASE ORDER</h4>
        @if (count($data) > 0)
        <h4 style="text-align:center">{{ $data[0]->nopo}}<h4/> 
        <h4 style="text-align:center">{{ date_create($data[0]->tgl_masuk)->format('d-m-Y') }}</h4>

        <p>Kepada :</p>
        <p>{{ $data[0]->nama_supplier }}</p>
        <p>{{ $data[0]->alamat }}</p>

        <table class="table table-sm table-bordered" style="margin-top:1.5em; margin-bottom:1em">
            <thead>
                <tr>
                    <td class="captioncenter">No</td>
                    <td class="captioncenter">Jenis Barang</td>
                    <td class="captionright">Banyakya</td>
                    <td class="captionright">Harga Satuan</td>
                    <td class="captionright">Jumlah</td>
                    <td class="captioncenter">Keterangan</td>
                </tr>
            </thead>
            <tbody>
                @php 
                    $i = 1;
                @endphp
                @foreach ($data as $po)
                        <tr>
                            <td class="captioncenter" style="width:5%">{{ $i++ }}</td>
                            <td class="captionleft">{{ isset($po->nama_material) ? $po->nama_material : $po->nama_barang }}</td>
                            <td class="captionright" style="width:10%">{{ number_format($po->jumlah,2,".",",") }}</td>
                            <td class="captionright" style="width:15%">{{ number_format($po->harga/(1+($pajak->pajak/100)),2,".",",") }}</td>
                            <td class="captionright" style="width:15%">{{ number_format($po->jumlah * $po->harga/(1+($pajak->pajak/100)),2,".",",") }}</td>
                            <td></td>
                        </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan=4 class="captionleft">DPP</td>
                    <td class="captionright">{{ number_format($data[0]->dpp,2,".",",") }}</td>
                    <td></td>
                </tr>
                <tr>
                    <td colspan=4 class="captionleft">PPN {{ $pajak->persen.'%' }}</td>
                    <td class="captionright">{{ number_format($data[0]->ppn,2,".",",") }}</td>
                    <td></td>
                </tr>
                <tr>
                    <td colspan=4 class="captionleft">Total</td>
                    <td class="captionright">{{ number_format($data[0]->total,2,".",",") }}</td>
                    <td></td>
                </tr>
            </tfoot>
        </table>
        <table style="margin-top:2em; width:100%;">
            <tr>
                <td style="height:10em;text-align:center; width:33%;font-weight:bold;">Disetujui Oleh</td>
                <td style="height:10em;text-align:center;width:33%;font-weight:bold">Diketahui Oleh</td>
                <td style="height:10em;text-align:center;font-weight:bold">Diorderkan Oleh</td>
            </tr>
            <tr>
                <td style="text-align:center">(_____________)</td>
                <td style="text-align:center">(_____________)</td>
                <td style="text-align:center">(_____________)</td>
            </tr>
        </table>
        @endif
    </body>
</html>