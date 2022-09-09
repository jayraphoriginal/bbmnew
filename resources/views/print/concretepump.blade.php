<html>

    <head>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <style>
            *{
                font-family: Arial, Helvetica, sans-serif
                font-size:14px;
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
                font-size:14px;
            }
            .captioncenter{
                font-weight:bold;
                text-align:center;
                font-size:14px;
            }
            .captionleft{
                font-weight:bold;
                text-align:left;
                width:20%;
                font-size:14px;
            }
            .captionright{
                font-weight:bold;
                text-align:right;
                font-size:14px;
            }  
            .table{
                outline-style: solid;
                outline-width: 2px;
            }
            .borderleft{
                border-left: 2px solid;
            }
            td{
                font-size:14px;
            }
        </style>
        <title>Concrete Pump</title>
    </head>


    <body>
        <div style="margin:auto; padding-left:1rem">
            <h6 style="text-align:center; text-decoration:underline">LAPORAN OPERASI MESIN</h6>
            <h6 style="text-align:center">MACHINE OPERATION REPORT</h6>
        </div>
        <table style="margin-top:1rem">
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
        
        <table style="margin-top:1rem; margin-bottom:1rem; width:100%;">
            <thead>
                <tr>
                    <td colspan="2" style="text-align: center; border: solid 1px #000">Waktu Operasi</td>
                    <td rowspan="2" style="text-align: center; border: solid 1px #000">Jumlah Waktu Beroperasi</td>
                    <td rowspan="2" style="text-align: center; border: solid 1px #000">Keterangan (Volume M<sup>3</sup>)</td>
                </tr>
                <tr>
                    <td style="text-align: center; border: solid 1px #000">Awal</td>
                    <td style="text-align: center; border: solid 1px #000">Akhir</td>
                </tr>
            </thead>
            <tbody>
                @if(!is_null($detail))
                    <tr>
                        <td style="height:6rem; text-align:center; border: solid 1px #000">{{ date_format(date_create($detail->jam_awal),'H:i') }}</td>
                        <td style="height:6rem; text-align:center;border: solid 1px #000">{{ date_format(date_create($detail->jam_akhir),'H:i') }}</td>
                        <td style="height:6rem; text-align:center;border: solid 1px #000">{{ date_diff(date_create($detail->jam_awal),date_create($detail->jam_akhir))->format('%h Jam %i Menit') }}</td>
                        <td style="height:6rem; text-align:center;border: solid 1px #000">{{ $detail->volume }} M<sup>3</sup></td>
                    </tr>
                @else
                <tr>
                   <td style="height:6rem; border: solid 1px #000"></td>
                   <td style="height:6rem; border: solid 1px #000"></td>
                   <td style="height:6rem; border: solid 1px #000"></td>
                   <td style="height:6rem; border: solid 1px #000"></td>
                </tr>
                @endif
            </tbody>
        </table>

        <table style="width:100%;">
            <tr>
                <td style="text-align:center; width:20%;">Pengawas Pihak</td>
                <td style="text-align:center;width:60%;"></td>
                <td style="text-align:center;width:30%">Operator / Supir</td>
            </tr>

            <tr>
                <td style="height:5em; text-align:center; vertical-align:top; width:20%;">Controller</td>
                <td style="height:5em; text-align:center; vertical-align:top; width:60%;"></td>
                <td style="height:5em; text-align:center; vertical-align:top; width:30%"></td>
            </tr>

            <tr>
                <td style="text-align:center;width:20%;">(_______________)</td>
                <td style="text-align:center;width:60%;"></td>
                <td style="text-align:center;width:30%">{{ '('.$header->nama_driver.')' }}</td>
            </tr>
        </table>

    </body>

</html>