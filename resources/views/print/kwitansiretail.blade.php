<html>

    <head>
        <style>
            *{
                font-size:16px;
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
        <div style="width:100%;border:solid 1px;overflow:auto;height:100%;padding:10px">
            <h4 style="margin-top:1em;text-decoration:underline;font-size:18px;">KWITANSI</h4>
            <table style="float:right">
                <tr>
                    <td class="captioncenter">{{ "No Kwitansi. ".$data[0]->nokwitansi }}</td>
                </tr>
            </table>

            <table style="width:80%;height:45%">
                <tr>
                    <td style="width: 150px;">Telah diterima dari</td>
                    <td style="width:20px;">:</td>
                    <td>{{ $data[0]->nama_pemilik }}</td>
                </tr>
                <tr>
                    <td style="padding-top: 18px;">Untuk Pembayaran</td>
                    <td style="padding-top: 18px;">:</td>
                    <td style="padding-top: 18px;">
                        @if($data[0]->keterangan == '')
                            @foreach($data as $jual)
                                <div>
                                    @if( substr($jual->uraian,0,2) == 'DP' )
                                        {{ $jual->uraian }}
                                    @else
                                        @if($jual->tipe_so=='Sewa')
                                        @else
                                            {{ $jual->uraian.' '.number_format($jual->jumlah,0,',','.').' '.$jual->satuan}}
                                        @endif
                                    @endif
                                </div>
                            @endforeach
                        @else
                            <div>{!! $data[0]->keterangan !!}</div>
                        @endif
                    </td>
                </tr>
            </table>
             <table style="float:left;width:68%;">
                <tr>
                    <td colspan=3 style="height:5em;font-weight:bold;text-decoration:underline;">Rp {{ number_format($data[0]->total,0,',','.') }}</td>
                </tr>
                <tr>
                    <td style="width:30%;">Uang Sejumlah</td>
                    <td style="width:3%;">:</td>
                    <td style="font-weight:bold;font-style:italic;border:solid 1px;padding:5px;">{{ ucwords($terbilang).' Rupiah' }}</td>
                </tr>
            </table>
            <table style="float:right;width:30%;margin-top:2rem;">
                <tr>
                    <td style="text-align:left; width:30%">Palembang, {{ date_format(date_create($data[0]->tgl_cetak), 'd M Y') }}</td>
                </tr>
                <tr>
                    <td style="height:14em;text-align:left; width:30%:" style="width:30%">Karno</td>
                </tr>
            </table>
        </div>
    </body>

</html>