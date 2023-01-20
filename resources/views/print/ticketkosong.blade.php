<html>

    <head>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <style>
            *{
                font-family: Arial, Helvetica, sans-serif;
                font-size:12px;
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
                border-left: 2px solid;
            }
        </style>
        <title></title>
    </head>


    <body>
        <div style="border: 2px solid; margin:auto; padding-left:1rem; margin-top:1rem;">
            <h3 style="text-align:center;">Ticket Material</h3>
            <p style="text-align:center">No Ticket : </p>
            <p style="margin-bottom:30px;">Pekerjaan</p>
            <p style="font-weight:bold;"></p>
        </div>
        <table class="table table-sm" style="margin-top:1rem">
            <tr>
                <td class="kl1">No Polisi</td>
                <td class="kl2">: </td>
            </tr>
            <tr>
                <td class="kl1">Mutu Beton</td>
                <td class="kl2">: </td>
            </tr>
        </table>
        
        <table class="table table-sm" style="margin-top:1em;">
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
                    <td class="captionleft">: </td>
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

        <table class="table table-sm" style="width:100%;">
            <tr>
                <td style="height:6em;text-align:center; width:33%;font-weight:bold;">Dikirim Oleh</td>
                <td class="border-left" style="text-align:center;width:33%;font-weight:bold">Dibawa Oleh</td>
                <td class="border-left" style="text-align:center;font-weight:bold">Diterima Oleh</td>
            </tr>

            <tr>
                <td class="text-align:center" style="width:33%"></td>
                <td class="border-left" style="width:33%;text-align:center"></td>
                <td class="text-align:center border-left"></td>
            </tr>
        </table>

    </body>
</html>