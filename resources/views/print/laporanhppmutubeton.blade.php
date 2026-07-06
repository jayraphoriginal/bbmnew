<html>

    <head>
        <title>HPP Penjualan Beton</title>
    </head>

    <style>
        .mytable>tbody>tr>td, .mytable>tbody>tr>th, .mytable>tfoot>tr>td, .mytable>tfoot>tr>th, .mytable>thead>tr>td, .mytable>thead>tr>th {
            padding: 5px;
            vertical-align: middle;
            margin:0;
        }
        *{
            font-size:14px;
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
        <div style="margin-bottom: 3rem;">
            <h3 style="margin-bottom: 3rem;text-align:center; font-size: 16px;">DAFTAR HPP MUTU BETON</h3>
                <table style="margin-bottom: 3rem;">
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
                    @php
                        $komponens = '';
                        $total = 0;
                    @endphp
                    @foreach($drv as $komponen => $data2)
                        @if($komponens != $data2->komponen)
                            <tr style="background-color: #d3d3d3; font-weight: bold;">
                                <td colspan="6">{{ $data2->komponen }}</td>
                            </tr>
                            @php
                                $komponens = $data2->komponen;
                            @endphp
                        @endif
                        <tr style="background-color: #f0f0f0; padding: left 2px;">
                            <td>{{ $data2->kriteria }} </td>
                            <td>:</td>
                            <td class="text-right">{{ number_format($data2->harga, 2, '.', ',') }}</td>
                            <td class="text-right">X</td>
                            <td class="text-right">{{ rtrim(rtrim(number_format($data2->jumlah, 4, ',', '.'), '0'), ','); }}</td>
                            <td class="text-right">{{ number_format($data2->jumlah * $data2->harga, 2, '.', ',') }}</td>
                        </tr>
                        @php
                            $total += $data2->jumlah * $data2->harga;
                        @endphp
                    @endforeach 
                    <tr style="background-color: #d3d3d3; font-weight: bold;">
                        <td colspan="5" class="text-right">Total</td>
                        <td class="text-right">{{ number_format($total, 2, '.', ',') }}</td>
                    </tr>
                </table>

                <table style="margin-bottom: 3rem;">
                    <tr>
                        <td style="font-weight: bold; font-size: 16px;">Total HPP Mutu Beton {{ $drv->first()->deskripsi }} (100 M<sup>3</sup>)</td>
                        <td style="width: 10em; text-align: center;"> : </td>
                        <td style="font-weight: bold; font-size: 16px; text-align: right;">{{ number_format($total, 2, '.', ',') }}</td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold; font-size: 16px;">Total HPP Mutu Beton {{ $drv->first()->deskripsi }} (1 M<sup>3</sup>)</td>
                        <td style="width: 10em; text-align: center;"> : </td>
                        <td style="font-weight: bold; font-size: 16px; text-align: right;">{{ number_format($total/100, 2, '.', ',') }}</td>
                    </tr>
                </table>

                <hr style="border: 1px solid black; margin-bottom: 3rem;">
                @unless($loop->last)
                    <div class="page_break"></div>
                @endunless
            </div>
        @endforeach
    </body>

</html>