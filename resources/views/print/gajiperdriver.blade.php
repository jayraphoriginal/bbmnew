<html>

    <head>
        <title>Rekap Gaji</title>
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
            margin:0;
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
            $kendaraans = $data->groupBy('nopol');
            $kendaraans->toArray();
            $jumlah = count($kendaraans);
            $urut = 1;
            $totalgaji = 0;
            $totalpengisian = 0;
            $totalpemakaian = 0;
            $totallembur = 0;
            $totalrate = 0;
            $totalloading=0;
        @endphp        
        
        @foreach ($kendaraans as $kendaraan => $drv )
        <h3 style="margin-bottom: 3rem;text-align:center">REKAP GAJI</h3>
            <table style="margin-bottom: 3rem;">
                <tr>
                    <td style="width: 10em;">Nama</td>
                    <td> : </td>
                    <td>{{ $drv[0]->nama_driver }}</td>
                    <td style="width: 45em;"></td>
                    <td>Tanggal</td>
                    <td> : </td>
                    <td style="text-align:right;">{{ date_create($drv[0]->tanggal_awal)->format('d m Y').' - '.date_create($drv[0]->tanggal_akhir)->format('d m Y') }}</td>
                </tr>
                <tr>
                    <td style="width: 10em;">Nomor Polisi</td>
                    <td> : </td>
                    <td>{{ $kendaraan }}</td>
                    <td style="width: 45em;"></td>
                    <td>Periode</td>
                    <td> : </td>
                    <td style="text-align:right;">{{ $drv[0]->periode+1 }} Hari</td>
                </tr>
            </table>

            <table class="mytable" style="margin-bottom:4em;width:100%">
                <tr>
                    <td class="tdhead" style="text-align:center;">No</td>
                    <td class="tdhead" style="text-align:center;">Tanggal</td>
                    <td class="tdhead" style="text-align:center;">Customer</td>
                    <td class="tdhead" style="text-align:center;">Lokasi</td>
                    <td class="tdhead" style="text-align:center;">Jarak</td>
                    <td class="tdhead" style="text-align:center;">Liter</td>
                    <td class="tdhead" style="text-align:center;">Rate</td>
                    <td class="tdhead" style="text-align:center;">Total Liter</td>
                    <td class="tdhead" style="text-align:center;">Lembur</td>
                    <td class="tdhead" style="text-align:center;">Gaji</td>
                    <td class="tdhead" style="text-align:center;">Total Gaji</td>
                    <td class="tdhead" style="text-align:center;">BBM</td>
                </tr>
            @foreach($drv as $index => $data)
                @if($data->pengisian_bbm > 0) 
                <tr style="background-color: #ccc;">
                @else
                <tr>
                @endif
                    <td>{{ ++$index }}</td>
                    <td>{{ date_format(date_create($data->tanggal_ticket),'d-m-Y') }}</td>
                    <td>{{ $data->nama_customer }}</td>
                    <td>{{ $data->lokasi }}</td>
                    <td style="text-align:right;">{{ number_format($data->jarak,2,'.',',') }}</td>
                    <td style="text-align:right;">{{ number_format($data->pemakaian_bbm,2,'.',',')  }}</td>
                    @if($data->pengisian_bbm > 0) 
                        <td style="text-align:right;"></td>
                    @else
                        <td style="text-align:right;">{{ $data->rate  }}</td>
                    @endif
                    <td style="text-align:right;">{{ number_format($data->total_liter,2,'.',',')  }}</td>
                    <td style="text-align:right;">{{ number_format($data->lembur,2,'.',',')  }}</td>
                    <td style="text-align:right;">{{ number_format($data->gaji,2,'.',',')  }}</td>
                    <td style="text-align:right;">{{ number_format($data->total_gaji,2,'.',',')  }}</td>
                    <td style="text-align:right;">{{ number_format($data->pengisian_bbm,2,'.',',') }}</td>
                </tr>
                @php
                    $totalgaji = $totalgaji + $data->total_gaji;
                    $totalpemakaian = $totalpemakaian + $data->total_liter;
                    $totalpengisian = $totalpengisian + $data->pengisian_bbm;
                    if ($data->pengisian_bbm <=0){
                        $totalrate = $totalrate + $data->rate;
                    }
                    $totalloading = $totalloading + $data->loading;
                    $totallembur = $totallembur + $data->lembur;
                @endphp

            @endforeach 

            @php

                $totalpengurangan = $totalpemakaian + $totalloading - $totalpengisian;
                if($totalpengurangan > 0){
                    $hargabbm = $bbm->harga_claim;
                }else{
                    $hargabbm = $bbm->harga_beli;
                }

            @endphp
            <tr>
                <td colspan="6">
                    Total
                </td>
                <td style="text-align:right;">{{ number_format($totalrate,2,'.',',') }}</td>
                <td style="text-align:right;">{{ number_format($totalpemakaian,2,'.',',') }}</td>
                <td style="text-align:right;">{{ number_format($totallembur,2,'.',',') }}</td>
                <td style="text-align:right;">{{ number_format($totalgaji,2,'.',',') }}</td>
                <td style="text-align:right;">{{ number_format($totalgaji,2,'.',',') }}</td>
                <td style="text-align:right;">{{ number_format($totalpengisian ,2,'.',',')}}</td>
            </tr>
            <tr>
                <td colspan="6">
                    Total Tambahan Loading Bongkar @ 2.5 Liter X {{ number_format($totalrate,2,'.',',') }} 
                </td>
                <td></td>
                <td style="text-align:right;">{{ number_format($totalloading,2,'.',',') }}</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
            <td colspan="6">
                    Total
                </td>
                <td style="text-align:right;">{{ number_format($totalrate,0,'.',',') }}</td>
                <td style="text-align:right;">{{ number_format($totalpemakaian + $totalloading,2,'.',',') }}</td>
                <td style="text-align:right;">{{ number_format($totallembur,2,'.',',') }}</td>
                <td style="text-align:right;">{{ number_format($totalgaji,2,'.',',') }}</td>
                <td style="text-align:right;">{{ number_format($totalgaji,2,'.',',') }}</td>
                <td style="text-align:right;">{{ number_format($totalpengisian,2,'.',',') }}</td>
            </tr>
            </table>

            <table>
                <tr>
                    <td style="width:10em; ">Pemakaian BBM</td>
                    <td style="width:2em;"> : </td>
                    <td style="text-align:right;">{{ $totalpemakaian + $totalloading.' Liter' }}</td>
                    <td style="width:25em;"></td>
                    <td style="width:10em;">Gaji</td>
                    <td> : </td>
                    <td style="width:10em;"></td>
                    <td style="width:10em;text-align:right;">{{ number_format($totalgaji,2,'.',',') }}</td>
                </tr>
                <tr>
                    <td style="width:10em;">Pengisian BBM</td>
                    <td style="width:2em;"> : </td>
                    <td style="text-align:right;">{{ number_format($totalpengisian,2,',','.').' Liter' }}</td>
                    <td style="width:25em;"></td>
                    <td style="width:10em;">Lembur</td>
                    <td style="width:5em;"> : </td>
                    <td style="width:10em;"></td>
                    <td style="width:10em;text-align:right;">{{ number_format($totallembur,2,'.',',') }}</td>
                </tr>
                <tr>
                    <td style="width:10em;"></td>
                    <td style="width:2em;"></td>
                    <td style="text-align:right; border-bottom: 2px solid;"></td>
                    <td style="width:25em;"></td>
                    <td style="width:10em;">Uang BBM</td>
                    <td style="width:5em;"> : </td>
                    <td style="width:10em;">{{ number_format($totalpengurangan,2,'.',',') }} X {{ number_format($hargabbm ,2,',','.')}}</td>
                    <td style="width:10em;text-align:right;"> {{ number_format($totalpengurangan * $hargabbm,2,'.',',') }}</td>
                </tr>
                <tr>
                    <td style="width:10em;"></td>
                    <td style="width:2em;"></td>
                    <td style="text-align:right;">{{ number_format($totalpengurangan,2,',','.').' Liter' }}</td>
                    <td style="width:25em;"></td>
                    <td style="width:10em;"></td>
                    <td style="width:5em;"></td>
                    <td style="width:10em;"></td>
                    <td style="width:10em; border-bottom: 2px solid;"></td>
                </tr>
                <tr>
                    <td style="width:10em;"></td>
                    <td style="width:2em;"></td>
                    <td style="text-align:right;"></td>
                    <td style="width:25em;"></td>
                    <td></td>
                    <td style="width:5em;"></td>
                    <td style="width:10em;"></td>
                    <td style="width:10em;text-align:right; font-size:16px; font-weight:bold;">{{ number_format(($totalpengurangan * $hargabbm) + $totallembur + $totalgaji,2,'.',',')  }}</td>
                </tr>
            </table>

            @if ($urut++ < $jumlah )
                
                @php
                    $totalgaji = 0;
                    $totalpengisian = 0;
                    $totalpemakaian = 0;
                    $totallembur = 0;
                    $totalrate = 0;
                    $totalloading=0;
                @endphp

                <div class="page_break"></div>
            @endif
            
        @endforeach
    </body>

</html>