<html>

    <head>
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
        <title>{{ $data[0]->nokwitansi }}</title>
    </head>

    <body style="height:40%;">
       
        <div style="float:left;width:10%;border:solid 1px;padding:10px;overflow:auto;height:100%">
            @if($data[0]->tipe <> 'Retail')
            <img src="{{ asset('/img/logobbm.jpeg') }}" width="70px" style="margin-top:40px;"/>
            @endif
        </div>
        <div style="float:right;width:82%;border:solid 1px;overflow:auto;height:100%;padding:8px">
            <h4 style="margin-top:1em; text-align:center; text-decoration:underline;margin-bottom:5px">KWITANSI</h4>
            <table style="float:right;">
                <tr>
                    <td class="captioncenter">{{ "No Kwitansi. ".$data[0]->nokwitansi }}</td>
                </tr>
            </table>

            <table style="width:100%;height:45%">
                <tr>
                    <td style="width: 130px;height:30px;">Telah diterima dari</td>
                    <td style="width:20px">:</td>
                    @if($data[0]->tipe == 'Retail')
                    <td>{{ $data[0]->nama_pemilik }}</td>
                    @else
                    <td>{{ $data[0]->nama_customer }}</td>
                    @endif
                    
                </tr>
                <tr>
                    <td style="height:30px;"">Uang Sejumlah</td>
                    <td>:</td>
                    <td style="background-color:#ccc;font-weight:bold;font-style:italic;">{{ ucwords($terbilang).' Rupiah' }}</td>
                </tr>
                <tr>
                    <td style="padding-top: 3px;">Untuk Pembayaran</td>
                    <td style="padding-top: 3px;">:</td>
                    <td style="padding-top: 3px;vertical-align:top;">
                        @foreach($data as $jual)
                            <div>
                                @if( substr($jual->uraian,0,2) == 'DP' )
                                    {{ $jual->uraian }}
                                @else
                                    @if($jual->tipe_so=='Sewa')
                                    @else
                                        {{ $jual->uraian.' '.number_format($jual->jumlah,1,',','.').' '.$jual->satuan}} <br/>
                                    @endif
                                @endif
                            </div>
                        @endforeach
                            <div>{!! $data[0]->keterangan !!}</div>
                    </td>
                </tr>
            </table>
             <table style="float:left;width:40%;">
                <tr>
                    <td style="width:5%;background-color:#ccc;font-weight:bold;">Rp</td>
                    <td style="height:2em;text-align:right; width:30%;background-color:#ccc;font-weight:bold;font-style:italic;">{{ number_format($data[0]->total,0,',','.') }}</td>
                </tr>
            </table>
            <table style="float:right;width:30%;margin-top:2rem;">
                <tr>
                    <td style="text-align:left; width:30%">Palembang, {{ date_format(date_create($data[0]->tgl_cetak), 'd M Y') }}</td>
                </tr>
                <tr>
                    <td style="text-align:left; font-weight:bold; width:30%">PT. Bintang Beton Mandala</td>
                </tr>
                <tr>
                    <td style="height:14em;text-align:left; width:30%" style="width:30%">{{ $data[0]->tanda_tangan }}</td>
                </tr>
            </table>
            <p style="float:right;margin-top:13rem;text-align:right">I</p>
        </div>
        
        <div class="page_break"></div>

        <div style="float:left;width:10%;border:solid 1px;padding:10px;overflow:auto;height:100%">
            @if($data[0]->tipe <> 'Retail')
                <img src="{{ asset('/img/logobbmblackwhite.jpg') }}" width="70px" style="margin-top:40px;"/>
            @endif
        </div>
        <div style="float:right;width:82%;border:solid 1px;overflow:auto;height:100%;padding:8px">
            <h4 style="margin-top:1em; text-align:center; text-decoration:underline;margin-bottom:5px">KWITANSI</h4>
            <table style="float:right;">
                <tr>
                    <td class="captioncenter">{{ "No Kwitansi. ".$data[0]->nokwitansi }}</td>
                </tr>
            </table>

            <table style="width:100%;height:45%">
                <tr>
                    <td style="width: 130px;height:30px;">Telah diterima dari</td>
                    <td style="width:20px">:</td>
                    @if($data[0]->tipe == 'Retail')
                    <td>{{ $data[0]->nama_pemilik }}</td>
                    @else
                    <td>{{ $data[0]->nama_customer }}</td>
                    @endif
                    
                </tr>
                <tr>
                    <td style="height:30px;"">Uang Sejumlah</td>
                    <td>:</td>
                    <td style="background-color:#ccc;font-weight:bold;font-style:italic;">{{ ucwords($terbilang).' Rupiah' }}</td>
                </tr>
                <tr>
                    <td style="padding-top: 3px;">Untuk Pembayaran</td>
                    <td style="padding-top: 3px;">:</td>
                    <td style="padding-top: 3px;vertical-align:top;">
                        @foreach($data as $jual)
                            <div>
                                @if( substr($jual->uraian,0,2) == 'DP' )
                                    {{ $jual->uraian }}
                                @else
                                    @if($jual->tipe_so=='Sewa')
                                    @else
                                        {{ $jual->uraian.' '.number_format($jual->jumlah,1,',','.').' '.$jual->satuan}} <br/>
                                    @endif
                                @endif
                            </div>
                        @endforeach
                            <div>{!! $data[0]->keterangan !!}</div>
                    </td>
                </tr>
            </table>
             <table style="float:left;width:40%;">
                <tr>
                    <td style="width:5%;background-color:#ccc;font-weight:bold;">Rp</td>
                    <td style="height:2em;text-align:right; width:30%;background-color:#ccc;font-weight:bold;font-style:italic;">{{ number_format($data[0]->total,0,',','.') }}</td>
                </tr>
            </table>
            <table style="float:right;width:30%;margin-top:2rem;">
                <tr>
                    <td style="text-align:left; width:30%">Palembang, {{ date_format(date_create($data[0]->tgl_cetak), 'd M Y') }}</td>
                </tr>
                <tr>
                    <td style="text-align:left; font-weight:bold; width:30%">PT. Bintang Beton Mandala</td>
                </tr>
                <tr>
                    <td style="height:14em;text-align:left; width:30%" style="width:30%">{{ $data[0]->tanda_tangan }}</td>
                </tr>
            </table>
            <p style="float:right;margin-top:13rem;text-align:right">II</p>
        </div>
        
        <div class="page_break"></div>

        <div style="float:left;width:10%;border:solid 1px;padding:10px;overflow:auto;height:100%">
            @if($data[0]->tipe <> 'Retail')
            <img src="{{ asset('/img/logobbmblackwhite.jpg') }}" width="70px" style="margin-top:40px;"/>
            @endif
        </div>
        <div style="float:right;width:82%;border:solid 1px;overflow:auto;height:100%;padding:8px">
            <h4 style="margin-top:1em; text-align:center; text-decoration:underline;margin-bottom:5px">KWITANSI</h4>
            <table style="float:right;">
                <tr>
                    <td class="captioncenter">{{ "No Kwitansi. ".$data[0]->nokwitansi }}</td>
                </tr>
            </table>

            <table style="width:100%;height:45%">
                <tr>
                    <td style="width: 130px;height:30px;">Telah diterima dari</td>
                    <td style="width:20px">:</td>
                    @if($data[0]->tipe == 'Retail')
                    <td>{{ $data[0]->nama_pemilik }}</td>
                    @else
                    <td>{{ $data[0]->nama_customer }}</td>
                    @endif
                    
                </tr>
                <tr>
                    <td style="height:30px;"">Uang Sejumlah</td>
                    <td>:</td>
                    <td style="background-color:#ccc;font-weight:bold;font-style:italic;">{{ ucwords($terbilang).' Rupiah' }}</td>
                </tr>
                <tr>
                    <td style="padding-top: 3px;">Untuk Pembayaran</td>
                    <td style="padding-top: 3px;">:</td>
                    <td style="padding-top: 3px;vertical-align:top;">
                        @foreach($data as $jual)
                            <div>
                                @if( substr($jual->uraian,0,2) == 'DP' )
                                    {{ $jual->uraian }}
                                @else
                                    @if($jual->tipe_so=='Sewa')
                                    @else
                                        {{ $jual->uraian.' '.number_format($jual->jumlah,1,',','.').' '.$jual->satuan}} <br/>
                                    @endif
                                @endif
                            </div>
                        @endforeach
                            <div>{!! $data[0]->keterangan !!}</div>
                    </td>
                </tr>
            </table>
             <table style="float:left;width:40%;">
                <tr>
                    <td style="width:5%;background-color:#ccc;font-weight:bold;">Rp</td>
                    <td style="height:2em;text-align:right; width:30%;background-color:#ccc;font-weight:bold;font-style:italic;">{{ number_format($data[0]->total,0,',','.') }}</td>
                </tr>
            </table>
            <table style="float:right;width:30%;margin-top:2rem;">
                <tr>
                    <td style="text-align:left; width:30%">Palembang, {{ date_format(date_create($data[0]->tgl_cetak), 'd M Y') }}</td>
                </tr>
                <tr>
                    <td style="text-align:left; font-weight:bold; width:30%">PT. Bintang Beton Mandala</td>
                </tr>
                <tr>
                    <td style="height:14em;text-align:left; width:30%" style="width:30%">{{ $data[0]->tanda_tangan }}</td>
                </tr>
            </table>
            <p style="float:right;margin-top:13rem;text-align:right">III</p>
        </div>
        
        <div class="page_break"></div>

        <div style="float:left;width:10%;border:solid 1px;padding:10px;overflow:auto;height:100%">
            @if($data[0]->tipe <> 'Retail')
            <img src="{{ asset('/img/logobbmblackwhite.jpg') }}" width="70px" style="margin-top:40px;"/>
            @endif
        </div>
        <div style="float:right;width:82%;border:solid 1px;overflow:auto;height:100%;padding:8px">
            <h4 style="margin-top:1em; text-align:center; text-decoration:underline;margin-bottom:5px">KWITANSI</h4>
            <table style="float:right;">
                <tr>
                    <td class="captioncenter">{{ "No Kwitansi. ".$data[0]->nokwitansi }}</td>
                </tr>
            </table>

            <table style="width:100%;height:45%">
                <tr>
                    <td style="width: 130px;height:30px;">Telah diterima dari</td>
                    <td style="width:20px">:</td>
                    @if($data[0]->tipe == 'Retail')
                    <td>{{ $data[0]->nama_pemilik }}</td>
                    @else
                    <td>{{ $data[0]->nama_customer }}</td>
                    @endif
                    
                </tr>
                <tr>
                    <td style="height:30px;"">Uang Sejumlah</td>
                    <td>:</td>
                    <td style="background-color:#ccc;font-weight:bold;font-style:italic;">{{ ucwords($terbilang).' Rupiah' }}</td>
                </tr>
                <tr>
                    <td style="padding-top: 3px;">Untuk Pembayaran</td>
                    <td style="padding-top: 3px;">:</td>
                    <td style="padding-top: 3px;vertical-align:top;">
                        @foreach($data as $jual)
                            <div>
                                @if( substr($jual->uraian,0,2) == 'DP' )
                                    {{ $jual->uraian }}
                                @else
                                    @if($jual->tipe_so=='Sewa')
                                    @else
                                        {{ $jual->uraian.' '.number_format($jual->jumlah,1,',','.').' '.$jual->satuan}} <br/>
                                    @endif
                                @endif
                            </div>
                        @endforeach
                            <div>{!! $data[0]->keterangan !!}</div>
                    </td>
                </tr>
            </table>
             <table style="float:left;width:40%;">
                <tr>
                    <td style="width:5%;background-color:#ccc;font-weight:bold;">Rp</td>
                    <td style="height:2em;text-align:right; width:30%;background-color:#ccc;font-weight:bold;font-style:italic;">{{ number_format($data[0]->total,0,',','.') }}</td>
                </tr>
            </table>
            <table style="float:right;width:30%;margin-top:2rem;">
                <tr>
                    <td style="text-align:left; width:30%">Palembang, {{ date_format(date_create($data[0]->tgl_cetak), 'd M Y') }}</td>
                </tr>
                <tr>
                    <td style="text-align:left; font-weight:bold; width:30%">PT. Bintang Beton Mandala</td>
                </tr>
                <tr>
                    <td style="height:14em;text-align:left; width:30%" style="width:30%">{{ $data[0]->tanda_tangan }}</td>
                </tr>
            </table>
            <p style="float:right;margin-top:13rem;text-align:right">IV</p>
        </div>
    </body>

</html>