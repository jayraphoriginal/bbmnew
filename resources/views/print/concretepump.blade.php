<html>

    <head>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <style>
            *{
                font-family: Arial, Helvetica, sans-serif
                font-size:12px;
            }

            @page{
                margin: 0.1in 0.2in 0.1in 0.3in;
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
        <title>Concrete Pump</title>
    </head>


    <body>
        <div style="border: 2px solid; margin:auto; padding-left:1rem">
            <h2 style="text-align:center; text-decoration:underline">LAPORAN OPERASI MESIN</h2>
            <p style="text-align:center">MACHINE OPERATION REPORT</p>
        </div>
        <table class="table table-sm" style="margin-top:1rem">
            <tr>
                <td class="kl1">NOPOL</td>
                <td class="kl2">: {{ $header->nopol }}</td>
            </tr>
            <tr>
                <td class="kl1">TANGGAL</td>
                <td class="kl2">: {{ date_format(date_create($header->created_date),'d M Y') }}</td>
            </tr>
            <tr>
                <td class="kl1">CUSTOMER</td>
                <td class="kl2">: {{ $header->nama_customer }}</td>
            </tr>
            <tr>
                <td class="kl1">LOKASI</td>
                <td class="kl2">: {{ $header->tujuan }}</td>
            </tr>
        </table>
        
        <table class="table table-sm" style="margin-top:1em;">
            <tbody>
                <tr>
                   
                   
                </tr>
                <tr>
                    
                </tr>
                <tr>
                   
                </tr>
                <tr>
                    
                </tr>
            </tbody>
        </table>

        <table class="table table-sm" style="width:100%;">
            <tr>
                <td style="height:4em;text-align:center; width:33%;font-weight:bold;">Pengawas Pihak</td>
                <td class="border-left" style="text-align:center;width:33%;font-weight:bold"></td>
                <td class="border-left" style="text-align:center;font-weight:bold">Operator / Supir</td>
            </tr>

            <tr>
                <td class="text-align:center" style="width:33%">Controller</td>
                <td class="border-left" style="width:33%;text-align:center"></td>
                <td class="text-align:center border-left">(                 )</td>
            </tr>

            <tr>
                <td class="text-align:center" style="width:33%"></td>
                <td class="border-left" style="width:33%;text-align:center"></td>
                <td class="text-align:center border-left">{{ '('.$header->nama_driver.')' }}</td>
            </tr>
        </table>

    </body>

</html>