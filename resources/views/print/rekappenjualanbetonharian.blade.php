<html>

    <head>
        <title>Laporan Penjualan Beton</title>
    </head>

    <style>
        .mytable>tbody>tr>td, .mytable>tbody>tr>th, .mytable>tfoot>tr>td, .mytable>tfoot>tr>th, .mytable>thead>tr>th {
            padding: 5px;
            vertical-align: middle;
            border:1px solid;
            margin:0;
        }
        table{
            border-collapse: collapse;
        }
        *{
            font-size:13px;
        }
        @page{
            margin: 0.1in 0.3in 0.2in 0.3in;
        }
        .page_break { 
            page-break-before: always; 
        }
        .tdhead{
            font-weight: bold;
        }
        .text-right{
            text-align: right;
        }
    </style>

    <body>
        <h2 style="text-align:center; font-size:18px;">Laporan Penjualan Beton</h2>
        <p style="text-align:center;">Rekap Pengiriman Beton Per Hari</p>
        @if (count($data) > 0)
        <p style="margin-bottom: 3rem;text-align:center; font-size:13px;">Periode : {{ date_format(date_create($tgl),'l,d/M/Y') }}</p>
        <table class="mytable" style="width:100%;">
            <tr>
                <td class="tdhead">No</td>
                <td class="tdhead">NoTicket</td>
                <td class="tdhead">Nopol</td>
                <!-- <td class="tdhead">No Ticket</td> -->
                <td class="tdhead">Kode Mutu</td>
                <td class="tdhead text-right">Volume</td>
                <td class="tdhead">Customer</td>
                <td class="tdhead">Lokasi</td>
            </tr>
            
            @php
                $total = 0;
            @endphp
            @foreach($data as $index => $item)
            @if($item->status=='Cancel')
            <tr style="background-color:#aaa;">
            @else
            <tr>
            @endif
                <td>{{ ++$index }}</td>
                <td>{{ $item->noticket }}</td>
                <td>{{ $item->nopol }}</td>
                <!-- <td>{{ $item->noticket }}</td> -->
                <td>{{ $item->kode_mutu }}</td>
                @if($item->status=='Cancel')
                    <td class="text-right">{{ '0 '.$item->satuan }}</td>
                    <td>{{ $item->nama_customer }}</td>
                    <td>{{ $item->tujuan.' (Cancel)'}}</td>
                @else
                    <td class="text-right">{{ number_format($item->jumlah,1,',','.').' '.$item->satuan }}</td>
                    <td>{{ $item->nama_customer }}</td>
                    <td>{{ $item->tujuan}}</td>
                @endif
            </tr>
                @php
                    if($item->status<>'Cancel'){
                        $total = $total + $item->jumlah;
                    }
                @endphp
            @endforeach 
            <tr>
                <td colspan="4" style="font-weight:bold">Total</td>
                <td class="text-right" style="font-weight:bold">{{ number_format($total,1,',','.').' '.$data[0]->satuan }}</td>
                <td colspan="2"></td>
            </tr>
        </table>
        <p style="margin-bottom:0px">Ket:</p>
        <div style="width: 100%;height:18rem">
            <div style="float:left;width:60%;">
                @php
                    $totalmutu = 0;
                @endphp
                <table style="width:100%">   
                @foreach($datacustomer as $customer)
                    <tr>
                        <td>{{ $customer->nama_customer.' - '.$customer->tujuan.' ('.$customer->kode_mutu.')' }}</td>
                        <td class="text-right">{{ number_format($customer->total,1,',','.').' '.$customer->satuan }}</td>
                    </tr>
                    @php
                        $totalmutu = $totalmutu + $customer->total;
                    @endphp
                @endforeach
                    <tr style="height: 20px;">
                        <td></td>
                        <td class="text-right" style="margin-top: 10px;border-top:3px solid;font-weight:bold;">{{ number_format($totalmutu,1,',','.').' '.$datacustomer[0]->satuan}}</td>
                    </tr>
                </table>
            </div>
            <div style="float:right;width:40%">
                <table style="width:100%;">
                    @php
                        $totalpenjualan = 0;
                    @endphp
                    @foreach($penjualanbulanan as $penjualan)
                        <tr>
                            <td style="width:70%;">Produksi Bulan {{ $penjualan->bulan }}</td>
                            <td style="width:5%">=</td>
                            <td style="width:25%" class="text-right">{{ number_format($penjualan->jumlah,1,',','.').' M3' }}</td>
                        </tr>
                        @php
                            $totalpenjualan = $totalpenjualan + $penjualan->jumlah;
                        @endphp
                    @endforeach
                    <tr style="height: 20px;">
                        <td style="margin-top: 10px;border-top:3px solid;font-weight:bold;">TOTAL</td>
                        <td style="margin-top: 10px;border-top:3px solid;font-weight:bold;">=</td>
                        <td class="text-right" style="margin-top: 10px;border-top:3px solid;font-weight:bold;">{{ number_format($totalpenjualan,1,',','.').' M3'}}</td>
                    </tr>
                </table>
            </div>
        </div>
        @endif
        <div style="">
            <table style="width:100%;">
                <tr>
                    <td style="height:4em;text-align:center; width:33%;font-weight:bold;">Diketahui Oleh</td>
                    <td style="text-align:center;width:33%;font-weight:bold">Diperiksa Oleh</td>
                    <td style="text-align:center;font-weight:bold">Dibuat Oleh</td>
                </tr>

                <tr>
                    <td style="height:4em;text-align:center; width:33%;" style="width:33%">( Ir. Juliano )</td>
                    <td style="width:33%;text-align:center">( Sony Suherman )</td>
                    <td style="text-align:center border-left"></td>
                </tr>
            </table>
        </div>
    </body>

</html>