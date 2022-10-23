<html>

    <head>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <style>
            *{
                font-size:14px;
            }
            table{margin:0rem}
            @page{
                margin: 0.1in 0.3in 0.1in 0.1in;
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
            .page_break { 
                page-break-before: always; 
            }
        </style>
        <title>{{ $data[0]->noinvoice }}</title>
    </head>

    <body>
        <h4 style="margin-top:1em; text-align:center; text-decoration:underline">KWITANSI</h4>
        <div style="float:left;width:15%">
            <img src="{{ asset('/img/logobbm.jpeg') }}" width="80px"/>
        </div>
        <div style="float:right;width:85%">
            <table style="float:right">
                <tr>
                    <td class="captioncenter">{{ "No Kwitansi. ".$data[0]->noinvoice }}</td>
                </tr>
            </table>

            <table style="width:80%">
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

            <table style="border:solid 1px; margin-top:1.5em; margin-bottom:1em;width:100%">
                <thead>
                    <tr>
                        <td class="captioncenter" style="border:solid 1px;">No</td>
                        <td class="captioncenter" style="border:solid 1px;">Uraian</td>
                        <td class="captionright" style="border:solid 1px;">Satuan</td>
                        <td class="captionright" style="border:solid 1px;">Harga</td>
                        <td class="captionright" style="border:solid 1px;">Jumlah</td>
                    </tr>
                </thead>
                <tbody>
                    @php 
                        $i = 1;
                    @endphp
                    @foreach ($data as $jual)
                        @if (empty($jual->uraian))
                            <tr>
                                <td class="captioncenter" style="width:5%;border:solid 1px; padding:3px;">{{ $i++ }}</td>
                                <td class="captionleft"  style="border:solid 1px;padding:3px;">{{ "Tambahan Biaya" }}</td>
                                <td class="captionright" style="width:10%;border:solid 1px;padding:3px;">{{ number_format(1,2,".",",") }}</td>
                                <td class="captionright" style="width:15%;border:solid 1px;padding:3px;">{{ number_format($data[0]->total,2,".",",") }}</td>
                                <td class="captionright" style="width:15%;border:solid 1px;padding:3px;">{{ number_format($data[0]->total,2,".",",") }}</td>
                            </tr>
                        @else
                            <tr>
                                <td class="captioncenter" style="width:5%;border:solid 1px;padding:3px;">{{ $i++.$jual->tipe }}</td>
                                <td class="captionleft"  style="border:solid 1px;padding:3px;">{{ $jual->tipe == 'DP' ? "DP ".$jual->uraian : $jual->uraian }}</td>
                                <td class="captionright" style="width:10%;border:solid 1px;padding:3px;">{{ number_format($jual->jumlah,2,".",",").' '.$jual->satuan }}</td>
                                <td class="captionright" style="width:15%;border:solid 1px;padding:3px;">{{ number_format($jual->harga_intax/(1+($jual->pajak/100)),2,".",",") }}</td>
                                <td class="captionright" style="width:15%;border:solid 1px;padding:3px;">{{ number_format($jual->jumlah * $jual->harga_intax/(1+($jual->pajak/100)),2,".",",") }}</td>
                            </tr>
                        @endif

                
                    @endforeach
                    
                </tbody>
            </table>
            <table style="float:right;width:40%;">
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
            <p style="float:right;margin-top:10rem;text-align:right">I</p>
        </div>
        
        <div class="page_break"></div>

        <h4 style="margin-top:1em; text-align:center; text-decoration:underline">KWITANSI</h4>
        <div style="float:left;width:15%">
            <img src="{{ asset('/img/logobbmblackwhite.jpg') }}" width="80px"/>
        </div>
        <div style="float:right;width:85%">
            <table style="float:right">
                <tr>
                    <td class="captioncenter">{{ "No Kwitansi. ".$data[0]->noinvoice }}</td>
                </tr>
            </table>

            <table style="width:80%">
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

            <table style="border:solid 1px; margin-top:1.5em; margin-bottom:1em;width:100%">
                <thead>
                    <tr>
                        <td class="captioncenter" style="border:solid 1px;">No</td>
                        <td class="captioncenter" style="border:solid 1px;">Uraian</td>
                        <td class="captionright" style="border:solid 1px;">Satuan</td>
                        <td class="captionright" style="border:solid 1px;">Harga</td>
                        <td class="captionright" style="border:solid 1px;">Jumlah</td>
                    </tr>
                </thead>
                <tbody>
                    @php 
                        $i = 1;
                    @endphp
                    @foreach ($data as $jual)
                        @if (empty($jual->uraian))
                            <tr>
                                <td class="captioncenter" style="width:5%;border:solid 1px; padding:3px;">{{ $i++ }}</td>
                                <td class="captionleft"  style="border:solid 1px;padding:3px;">{{ "Tambahan Biaya" }}</td>
                                <td class="captionright" style="width:10%;border:solid 1px;padding:3px;">{{ number_format(1,2,".",",") }}</td>
                                <td class="captionright" style="width:15%;border:solid 1px;padding:3px;">{{ number_format($data[0]->total,2,".",",") }}</td>
                                <td class="captionright" style="width:15%;border:solid 1px;padding:3px;">{{ number_format($data[0]->total,2,".",",") }}</td>
                            </tr>
                        @else
                            <tr>
                                <td class="captioncenter" style="width:5%;border:solid 1px;padding:3px;">{{ $i++.$jual->tipe }}</td>
                                <td class="captionleft"  style="border:solid 1px;padding:3px;">{{ $jual->tipe == 'DP' ? "DP ".$jual->uraian : $jual->uraian }}</td>
                                <td class="captionright" style="width:10%;border:solid 1px;padding:3px;">{{ number_format($jual->jumlah,2,".",",").' '.$jual->satuan }}</td>
                                <td class="captionright" style="width:15%;border:solid 1px;padding:3px;">{{ number_format($jual->harga_intax/(1+($jual->pajak/100)),2,".",",") }}</td>
                                <td class="captionright" style="width:15%;border:solid 1px;padding:3px;">{{ number_format($jual->jumlah * $jual->harga_intax/(1+($jual->pajak/100)),2,".",",") }}</td>
                            </tr>
                        @endif

                
                    @endforeach
                    
                </tbody>
            </table>
            <table style="float:right;width:40%;">
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
            <p style="float:right;margin-top:10rem;text-align:right">II</p>
        </div>
        
        <div class="page_break"></div>

        <h4 style="margin-top:1em; text-align:center; text-decoration:underline">KWITANSI</h4>
        <div style="float:left;width:15%">
            <img src="{{ asset('/img/logobbmblackwhite.jpg') }}" width="80px"/>
        </div>
        <div style="float:right;width:85%">
            <table style="float:right">
                <tr>
                    <td class="captioncenter">{{ "No Kwitansi. ".$data[0]->noinvoice }}</td>
                </tr>
            </table>

            <table style="width:80%">
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

            <table style="border:solid 1px; margin-top:1.5em; margin-bottom:1em;width:100%">
                <thead>
                    <tr>
                        <td class="captioncenter" style="border:solid 1px;">No</td>
                        <td class="captioncenter" style="border:solid 1px;">Uraian</td>
                        <td class="captionright" style="border:solid 1px;">Satuan</td>
                        <td class="captionright" style="border:solid 1px;">Harga</td>
                        <td class="captionright" style="border:solid 1px;">Jumlah</td>
                    </tr>
                </thead>
                <tbody>
                    @php 
                        $i = 1;
                    @endphp
                    @foreach ($data as $jual)
                        @if (empty($jual->uraian))
                            <tr>
                                <td class="captioncenter" style="width:5%;border:solid 1px; padding:3px;">{{ $i++ }}</td>
                                <td class="captionleft"  style="border:solid 1px;padding:3px;">{{ "Tambahan Biaya" }}</td>
                                <td class="captionright" style="width:10%;border:solid 1px;padding:3px;">{{ number_format(1,2,".",",") }}</td>
                                <td class="captionright" style="width:15%;border:solid 1px;padding:3px;">{{ number_format($data[0]->total,2,".",",") }}</td>
                                <td class="captionright" style="width:15%;border:solid 1px;padding:3px;">{{ number_format($data[0]->total,2,".",",") }}</td>
                            </tr>
                        @else
                            <tr>
                                <td class="captioncenter" style="width:5%;border:solid 1px;padding:3px;">{{ $i++.$jual->tipe }}</td>
                                <td class="captionleft"  style="border:solid 1px;padding:3px;">{{ $jual->tipe == 'DP' ? "DP ".$jual->uraian : $jual->uraian }}</td>
                                <td class="captionright" style="width:10%;border:solid 1px;padding:3px;">{{ number_format($jual->jumlah,2,".",",").' '.$jual->satuan }}</td>
                                <td class="captionright" style="width:15%;border:solid 1px;padding:3px;">{{ number_format($jual->harga_intax/(1+($jual->pajak/100)),2,".",",") }}</td>
                                <td class="captionright" style="width:15%;border:solid 1px;padding:3px;">{{ number_format($jual->jumlah * $jual->harga_intax/(1+($jual->pajak/100)),2,".",",") }}</td>
                            </tr>
                        @endif

                
                    @endforeach
                    
                </tbody>
            </table>
            <table style="float:right;width:40%;">
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
            <p style="float:right;margin-top:10rem;text-align:right">III</p>
        </div>
        
        <div class="page_break"></div>

        <h4 style="margin-top:1em; text-align:center; text-decoration:underline">KWITANSI</h4>
        <div style="float:left;width:15%">
            <img src="{{ asset('/img/logobbmblackwhite.jpg') }}" width="80px"/>
        </div>
        <div style="float:right;width:85%">
            <table style="float:right">
                <tr>
                    <td class="captioncenter">{{ "No Kwitansi. ".$data[0]->noinvoice }}</td>
                </tr>
            </table>

            <table style="width:80%">
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

            <table style="border:solid 1px; margin-top:1.5em; margin-bottom:1em;width:100%">
                <thead>
                    <tr>
                        <td class="captioncenter" style="border:solid 1px;">No</td>
                        <td class="captioncenter" style="border:solid 1px;">Uraian</td>
                        <td class="captionright" style="border:solid 1px;">Satuan</td>
                        <td class="captionright" style="border:solid 1px;">Harga</td>
                        <td class="captionright" style="border:solid 1px;">Jumlah</td>
                    </tr>
                </thead>
                <tbody>
                    @php 
                        $i = 1;
                    @endphp
                    @foreach ($data as $jual)
                        @if (empty($jual->uraian))
                            <tr>
                                <td class="captioncenter" style="width:5%;border:solid 1px; padding:3px;">{{ $i++ }}</td>
                                <td class="captionleft"  style="border:solid 1px;padding:3px;">{{ "Tambahan Biaya" }}</td>
                                <td class="captionright" style="width:10%;border:solid 1px;padding:3px;">{{ number_format(1,2,".",",") }}</td>
                                <td class="captionright" style="width:15%;border:solid 1px;padding:3px;">{{ number_format($data[0]->total,2,".",",") }}</td>
                                <td class="captionright" style="width:15%;border:solid 1px;padding:3px;">{{ number_format($data[0]->total,2,".",",") }}</td>
                            </tr>
                        @else
                            <tr>
                                <td class="captioncenter" style="width:5%;border:solid 1px;padding:3px;">{{ $i++.$jual->tipe }}</td>
                                <td class="captionleft"  style="border:solid 1px;padding:3px;">{{ $jual->tipe == 'DP' ? "DP ".$jual->uraian : $jual->uraian }}</td>
                                <td class="captionright" style="width:10%;border:solid 1px;padding:3px;">{{ number_format($jual->jumlah,2,".",",").' '.$jual->satuan }}</td>
                                <td class="captionright" style="width:15%;border:solid 1px;padding:3px;">{{ number_format($jual->harga_intax/(1+($jual->pajak/100)),2,".",",") }}</td>
                                <td class="captionright" style="width:15%;border:solid 1px;padding:3px;">{{ number_format($jual->jumlah * $jual->harga_intax/(1+($jual->pajak/100)),2,".",",") }}</td>
                            </tr>
                        @endif

                
                    @endforeach
                    
                </tbody>
            </table>
            <table style="float:right;width:40%;">
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
            <p style="float:right;margin-top:10rem;text-align:right">IV</p>
        </div>
    </body>

</html>