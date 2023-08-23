<html>

    <head>
        <style>
            .mytable>tbody>tr>td, .mytable>tbody>tr>th, .mytable>tfoot>tr>td, .mytable>tfoot>tr>th, .mytable>thead>tr>td, .mytable>thead>tr>th {
            padding: 5px;
            vertical-align: middle;
            margin:0;
            }
            *{
                font-family: Arial, Helvetica, sans-serif;
                font-size:12px;
            }
            table{
            border-collapse: collapse;
            }

            @page{
                margin: 0.3in 0.7in 0.1in 0.1in;
            }
            body{
                margin:0;
            }
            p{
                margin:0;
                font-size:14px;
            }
            .kl1{
                width:10em;
                font-size:14px;
            }
            .kl2{
                width:18em;
                font-size:14px;
            }
            .tglkanan{
                float:right;
                font-size:16px;
            }
            .captioncenter{
                font-weight:bold;
                text-align:center;
                font-size:16px;
            }
            .captionleft{
                font-weight:bold;
                text-align:left;
                width:20%;
                font-size:15px;
            }
            .captionright{
                font-weight:bold;
                text-align:right;
                font-size:15px;
            }  
            .table{
                outline-style: solid;
                outline-width: 2px;
            }
            .borderleft{
                border-left: 1px solid;
            }
            .bordertop{
                border-top: 1px solid;
            }
        </style>
        <title>TICKET PRODUKSI PRODUK TURUNAN</title>
    </head>


    <body>
        <div style="border: 2px solid; margin:auto; padding-left:1rem; margin-top:0;padding:top-0.5rem;padding-bottom:0.5rem">
            <p style="text-align:center;font-size:16px;font-weight:bold">Ticket Produksi Produk Turunan</p>
            <p style="text-align:center">No Ticket : {{ $data[0]->noticket }}</p>
        </div>
        <table class="mytable" style="margin-top:0.5rem; width:100%;border:2px solid"">
            <tr>
                <td class="kl1">No Polisi</td>
                <td class="kl2 borderleft">: {{ $data[0]->nopol }}</td>
            </tr>
            <tr>
                <td class="kl1">Mutu Beton</td>
                <td class="kl2 borderleft">: {{ $data[0]->deskripsi }}</td>
            </tr>
        </table>
        
        <table class="mytable" style="margin-top:0.5em;width:100%;border:2px solid">
            <tbody>
                <tr>
                    <td class="captionleft">Tanggal Pengiriman</td>
                    @if(is_null($data[0]->jam_ticket))
                        <td class="captionleft">: {{ date_format(date_create($data[0]->created_at),'d M Y') }}</td>  
                    @else
                        <td class="captionleft">: {{ date_format(date_create($data[0]->jam_ticket),'d M Y') }}</td>     
                    @endif
                    <td class="captionleft borderleft">Tanggal Penerimaan </td>
                    <td class="captionleft">: </td>
                </tr>
                <tr>
                    <td class="captionleft">Jam Pengiriman</td>
                    @if(is_null($data[0]->jam_ticket))
                        <td class="captionleft">: {{ date_format(date_create($data[0]->created_at),'H:i:s') }}</td>  
                    @else
                        <td class="captionleft">: {{ date_format(date_create($data[0]->jam_ticket),'H:i:s') }}</td>     
                    @endif
                    <td class="captionleft borderleft">Jam Tiba Lokasi</td>
                    <td class="captionleft">: </td>
                </tr>
                <tr>
                    <td class="captionleft">Volume</td>
                    <td class="captionleft">: {{ number_format($data[0]->jumlah,2,',','.').' M'}}<sup>3</sup></td>
                    <td class="captionleft borderleft">Jam Mulai Bongkar </td>
                    <td class="captionleft">: </td>
                </tr>
                <tr>
                    <td class="captionleft">Lokasi</td>
                    <td class="captionleft">: {{ $data[0]->tujuan }}</td>
                    <td class="captionleft borderleft">Jam Selesai Bongkar </td>
                    <td class="captionleft">: </td>
                </tr>
            </tbody>
        </table>

        <table class="mytable" style="margin-top:0.5em;width:100%;border:2px solid"">
            <tr>
                <td style="height:6em;text-align:center; width:33%;font-weight:bold;vertical-align:top">Dikirim Oleh</td>
                <td class="borderleft" style="text-align:center;width:33%;font-weight:bold;vertical-align:top">Dibawa Oleh</td>
                <td class="borderleft" style="text-align:center;font-weight:bold;vertical-align:top">Diterima Oleh</td>
            </tr>

            <tr>
                <td class="bordertop" style="width:33%"></td>
                <td class="borderleft bordertop" style="width:33%;text-align:center">{{$data[0]->nama_driver}}</td>
                <td class="borderleft bordertop"></td>
            </tr>
        </table>

    </body>

</html>