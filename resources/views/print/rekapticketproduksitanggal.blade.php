<html>

    <head>
        <title>Laporan Rekap Ticket</title>
    </head>

    <style>
        .mytable>tbody>tr>td, .mytable>tbody>tr>th, .mytable>tfoot>tr>td, .mytable>tfoot>tr>th, .mytable>thead>tr>td, .mytable>thead>tr>th {
            padding: 4px;
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
        .page_break { 
            page-break-before: always; 
        }
        .tdhead{
            font-weight: bold;
        }
        table{
            border-collapse: collapse;
        }
        .text-right{
            text-align: right;
        }
    </style>

    <body>
        
        <h4 style="text-align:center">Laporan Rekap Ticket Produksi</h4>
        @if (count($data) > 0)
        <h5 style="margin-bottom: 3rem;">Periode : {{ date_format(date_create($tgl_awal),'d/m/Y').' - '.date_format(date_create($tgl_akhir),'d/m/Y') }}</h5>
        <table class="mytable" style="width: 100%;">
            <tr>
                <td class="tdhead">No</td>
                <td class="tdhead">Tanggal</td>
                <td class="tdhead">No Ticket</td>
                <td class="tdhead">Nopol</td>
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
                <tr style="background-color:#aaa">
            @else
                <tr>
            @endif
                <td>{{ ++$index }}</td>
                <td>{{ date_format(date_create($item->jam_ticket),'d/m/Y') }}</td>
                <td>{{ $item->noticket }}</td>
                <td>{{ $item->nopol }}</td>
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
                    if ($item->status<>'Cancel'){
                        $total = $total + $item->jumlah;
                    }
                @endphp
            @endforeach 
            <tr>
                <td colspan="5" style="font-weight:bold">Total</td>
                <td class="text-right" style="font-weight:bold">{{ number_format($total,2,',','.').' '.$data[0]->satuan }}</td>
                <td colspan="2"></td>
            </tr>
        </table>
        @endif
        <p style="font-size: 16px;">Produksi per Mutu Beton</p>
        <table style="margin-top:5px;">
            <tr>
                <td style="width:150px;padding: 3px;">Kode Mutu</td>
                <td>Total</td>
            </tr>
            @php
                $total = 0;
            @endphp
            @foreach($totalmutu as $item)
                <tr>
                    <td style="width:150px;padding: 3px;">{{ $item->kode_mutu }}</td>
                    <td>{{ $item->jumlah }}</td>
                </tr>
                @php
                    $total = $total + $item->jumlah;
                @endphp
            @endforeach
            <tr>
                <td style="width:150px;padding: 3px;font-weight:bold">Total</td>
                <td style="padding: 3px;font-weight:bold">{{ $total }}</td>
            </tr>
        </table>
    </body>

</html>