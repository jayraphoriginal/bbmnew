<html>

    <head>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <style>
            *{
                font-size:14px;
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
        <h4 style="margin-top:1em; text-align:center; text-decoration:underline">KWITANSI</h4>
        
        <table style="float:right">
            <tr>
                <td class="captioncenter">{{ "No Kwitansi. ".$data[0]->noinvoice }}</td>
            </tr>
        </table>

        <table style="width:100%">
            <tr>
                <td style="width: 150px;height:50px;">Telah diterima dari</td>
                <td style="width:20px;">:</td>
                <td>{{ $data[0]->nama_customer }}</td>
            </tr>
            <tr>
                <td>Uang Sejumlah</td>
                <td>:</td>
                <td style="background-color:#ccc;font-weight:bold;font-size:16px;">{{ ucwords($terbilang).' Rupiah' }}</td>
            </tr>
        </table>

        <p style="margin-top:20px;">Untuk Pembayaran : </p>

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
                @endphp
                @foreach ($data as $jual)
                    @if (empty($jual->uraian))
                        <tr>
                            <td class="captioncenter" style="width:5%">{{ $i++ }}</td>
                            <td class="captionleft">{{ "Tambahan Biaya" }}</td>
                            <td class="captionright" style="width:10%">{{ number_format(1,2,",",".") }}</td>
                            <td class="captionright" style="width:15%">{{ number_format($data[0]->total,2,",",".") }}</td>
                            <td class="captionright" style="width:15%">{{ number_format($data[0]->total,2,",",".") }}</td>
                        </tr>
                    @else
                        <tr>
                            <td class="captioncenter" style="width:5%">{{ $i++.$jual->tipe }}</td>
                            <td class="captionleft">{{ $jual->tipe == 'DP' ? "DP ".$jual->uraian : $jual->uraian }}</td>
                            <td class="captionright" style="width:10%">{{ number_format($jual->jumlah,2,",",".").' '.$jual->satuan }}</td>
                            <td class="captionright" style="width:15%">{{ number_format($jual->harga_intax/(1+($jual->pajak/100)),2,",",".") }}</td>
                            <td class="captionright" style="width:15%">{{ number_format($jual->jumlah * $jual->harga_intax/(1+($jual->pajak/100)),2,",",".") }}</td>
                        </tr>
                    @endif

               
                @endforeach
                
            </tbody>
        </table>
        
        <table style="float:right;width:45%">
            <tr>
                <td style="height:2em;text-align:right; width:30%">Palembang, {{ date_format(now(), 'd M Y') }}</td>
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