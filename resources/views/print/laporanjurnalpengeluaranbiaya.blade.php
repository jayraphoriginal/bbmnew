<html>

    <head>
        <title>Laporan Jurnal Pengeluaran Biaya</title>
    </head>

    <style>
        .mytable>tbody>tr>td, .mytable>tbody>tr>th, .mytable>tfoot>tr>td, .mytable>tfoot>tr>th, .mytable>thead>tr>th {
            padding: 5px;
            vertical-align: middle;
            border:0px solid;
            margin:0;
        }
        table{
            border-collapse: collapse;
        }
        *{
            font-size:13px;
        }
        @page{
            margin: 0.3in 0.3in 0.2in 0.3in;
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
        
        <h2 style="text-align:center; font-size:18px;">Laporan Jurnal Pengeluaran Biaya</h2>
        @if (count($data) > 0)
        @php
            $trans = $data->groupBy('trans_id');
            $trans->toArray();
        @endphp
        <h3 style="margin-bottom: 2rem;font-size:14px;text-align:center;">Periode : {{ date_format(date_create($tgl_awal),'d/M/Y').' - '.date_format(date_create($tgl_akhir),'d/M/Y') }}</h3>
        <table class="mytable" style="width:100%">
            <tr>
                <td class="tdhead">No</td>
                <td class="tdhead">Tanggal Transaksi</td>
                <td class="tdhead">Kode Akun</td>
                <td class="tdhead">Nama Akun</td>
                <td class="tdhead text-right">Debet</td>
                <td class="tdhead text-right">Kredit</td>
            </tr>
            
            @php
                $totaldebet = 0;
                $totalkredit = 0;
                $index = 0;
            @endphp
            @foreach($trans as $tran => $items)
                @php
                    $totalsubdebet =0;
                    $totalsubkredit = 0;
                @endphp
                @foreach($items as $index => $item)
                <tr>
                    <td>{{ ++$index }}</td>
                    <td>{{ date_create($item->Tanggal_transaksi)->format('d-m-Y') }}</td>
                    <td>{{ $item->kode_akun }}</td>
                    <td>{{ $item->nama_akun }}</td>
                    <td class="text-right">{{ number_format($item->debet,2,',','.') }}</td>
                    <td class="text-right">{{ number_format($item->kredit,2,',','.') }}</td>
                </tr>
                    @php
                        $totalsubdebet = $totalsubdebet + $item->debet;
                        $totalsubkredit = $totalsubkredit + $item->kredit;
                        $totaldebet = $totaldebet + $item->debet;
                        $totalkredit = $totalkredit + $item->kredit;
                    @endphp
                @endforeach
                <tr>
                    <td colspan="4" style="font-weight:bold">Total</td>
                    <td class="text-right" style="font-weight:bold">{{ number_format($totalsubdebet,2,',','.') }}</td>
                    <td class="text-right" style="font-weight:bold">{{ number_format($totalsubkredit,2,',','.') }}</td>
                </tr>
                <tr>
                    <td colspan="6"></td>
                </tr>
            @endforeach 
            <tr>
                <td colspan="4" style="font-weight:bold">GrandTotal</td>
                <td class="text-right" style="font-weight:bold">{{ number_format($totaldebet,2,',','.') }}</td>
                <td class="text-right" style="font-weight:bold">{{ number_format($totalkredit,2,',','.') }}</td>
            </tr>
        </table>
        @endif
    </body>

</html>