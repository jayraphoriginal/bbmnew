<html>

    <head>
        <title>HPP Penjualan Beton</title>
    </head>

    <style>
        .mytable>tbody>tr>td, .mytable>tbody>tr>th, .mytable>tfoot>tr>td, .mytable>tfoot>tr>th, .mytable>thead>tr>td, .mytable>thead>tr>th {
            padding: 5px;
            vertical-align: middle;
            border:1px solid;
            margin:0;
        }
        *{
            font-size:13px;
        }
        @page{
            margin: 0.3in 0.3in 0.2in 0.3in;
        }
        body{
            margin: 30px;
        }
        table{
            border-collapse: collapse;
        }
        .page_break { 
            page-break-before: always; 
        }
        .text-right{
            text-align: right;
        }
    </style>

    <body>
        
        @php
            $mutubetons = $data->groupBy('mutubeton_id');
        @endphp        
        
        @foreach ($mutubetons as $mutubeton => $drv )
        <h3 style="margin-bottom: 2rem;text-align:center; font-size: 16px;">DAFTAR HPP MUTU BETON</h3>
            <table style="margin-bottom: 2rem;">
                <tr>
                    <td style="width: 10em; font-weight: bold; font-size: 16px;">Kode Mutu</td>
                    <td> : </td>
                    <td style="font-weight: bold; font-size: 16px;">{{ $drv->first()->deskripsi }}</td>
                </tr>
                <tr>
                    <td style="width: 10em; font-weight: bold; font-size: 16px;">Tanggal Berlaku</td>
                    <td> : </td>
                    <td style="font-weight: bold; font-size: 16px;">{{ date_create($tgl_berlaku)->format('d-m-Y') }}</td>
                </tr>
            </table>

            <table class="mytable" style="margin-bottom:4em;width:100%">
                <tr>
                    <td class="tdhead" style="text-align:center; font-weight: bold;">No</td>
                    <td class="tdhead" style="text-align:right;width:75px; font-weight: bold;">Jarak</td>
                    <td class="tdhead" style="text-align:right; font-weight: bold;">HPP Beton</td>
                    <td class="tdhead" style="text-align:right; font-weight: bold;">Profit</td>
                    <td class="tdhead" style="text-align:right; font-weight: bold;">Ongkos Mobil</td>
                    <td class="tdhead" style="text-align:right; font-weight: bold;">Pendapatan Mobil</td>
                    <td class="tdhead" style="text-align:right; font-weight: bold;">Total</td>
                    <td class="tdhead" style="text-align:right; font-weight: bold;">PPN</td>
                    <td class="tdhead" style="text-align:right; font-weight: bold;">Total + PPN</td>
                    <td class="tdhead" style="text-align:right; font-weight: bold;">Kenaikan</td>
                    <td class="tdhead" style="text-align:right; font-weight: bold;">Total Akhir</td>
                </tr>
                @foreach($drv as $index => $data2)
                    <tr>
                        <td>{{ ++$index }}</td>
                        <td style="text-align:right;"> < {{ $data2->batas_akhir }}</td>
                        <td style="text-align:right;">{{ number_format($data2->hpp,2,'.',',') }}</td>
                        <td style="text-align:right;">{{ number_format($data2->profit,2,'.',',') }}</td>
                        <td style="text-align:right;">{{ number_format($data2->ongkos_mobil,2,'.',',') }}</td>
                        <td style="text-align:right;">{{ number_format($data2->pendapatan_mobil,2,'.',',')  }}</td>
                        <td style="text-align:right;">{{ number_format($data2->total,2,'.',',')  }}</td>
                        <td style="text-align:right;">{{ number_format($data2->ppn,2,'.',',')  }}</td>
                        <td style="text-align:right; font-weight: bold;">{{ number_format($data2->grandtotal,2,'.',',')  }}</td>
                        <td style="text-align:right;">{{ number_format($data2->kenaikan,2,'.',',')  }}</td>
                        <td style="text-align:right; font-weight: bold;">{{ number_format($data2->total_akhir,2,'.',',') }}</td>
                    </tr>
                @endforeach 
            </table>

            <table style="margin-bottom: 2rem;">
                @foreach($dataharga as $index => $data3)
                    @if($data3->mutubeton_id == $mutubeton)
                        <tr>
                            <td style="width: 10em; font-weight: bold; font-size: 16px;">Harga {{ $data3->kriteria }}</td>
                            <td style="width: 10em; text-align: center;"> : </td>
                            <td style="font-weight: bold; font-size: 16px; text-align: right;">{{ number_format($data3->harga, 2, '.', ',') }}</td>
                        </tr>
                    @endif
                @endforeach 
            </table>

            <hr style="border-top: 1px solid black; margin-bottom: 2rem;">

            @unless($loop->last)
                <div class="page_break"></div>
            @endunless
            
        @endforeach
    </body>

</html>