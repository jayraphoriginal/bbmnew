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
        <title></title>
    </head>


    <body>
        <div style="border: 2px solid; margin:auto; padding-left:1rem; margin-top:0;padding-top:0.5rem;padding-bottom:0.5rem">
            <h3 style="text-align:center;">Ticket Material</h3>
            <p style="text-align:center">No Ticket : </p>
            <p>Pekerjaan</p>
            <p style="font-weight:bold;"></p>
        </div>
        <table class="mytable" style="margin-top:0.5rem; width:100%;border:2px solid"">
            <tr>
                <td class="kl1">No Urut Ticket</td>
                <td class="kl2 borderleft">: </td>
            </tr>
            <tr>
                <td class="kl1">No Polisi</td>
                <td class="kl2 borderleft">: </td>
            </tr>
            <tr>
                <td class="kl1">Mutu Beton</td>
                <td class="kl2 borderleft">: </td>
            </tr>
        </table>
        
        <table class="mytable" style="margin-top:0.5em;width:100%;border:2px solid">
            <tbody>
                <tr>
                    <td class="captionleft">Tanggal Pengiriman</td>
                    <td class="captionleft">: </td>  
                    <td class="captionleft borderleft">Tanggal Penerimaan </td>
                    <td class="captionleft">: </td>
                </tr>
                <tr>
                    <td class="captionleft">Jam Pengiriman</td>
                    <td class="captionleft">: </td>
                    <td class="captionleft borderleft">Jam Tiba Lokasi</td>
                    <td class="captionleft">: </td>
                </tr>
                <tr>
                    <td class="captionleft">Volume</td>
                    <td class="captionleft">:  </td>
                    <td class="captionleft borderleft">Jam Mulai Bongkar </td>
                    <td class="captionleft">: </td>
                </tr>
                <tr>
                    <td class="captionleft">Lokasi</td>
                    <td class="captionleft">: </td>
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
                <td class="bordertop" style="width:33%;height:15px"></td>
                <td class="borderleft bordertop" style="width:33%;text-align:center"></td>
                <td class="borderleft bordertop"></td>
            </tr>
        </table>

    </body>

</html>