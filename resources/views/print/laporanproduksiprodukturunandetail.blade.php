<html>

    <head>
        <title>Laporan Produksi Produk Turunan</title>
    </head>

    <style>
        .mytable>tbody>tr>td, .mytable>tbody>tr>th, .mytable>tfoot>tr>td, .mytable>tfoot>tr>th, .mytable>thead>tr>td, .mytable>thead>tr>th {
            padding: 5px;
            vertical-align: middle;
            border:1px solid;
        }
       *{
            font-size:13px;
        }
        table{
            border-collapse: collapse;
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
        .text-right{
            text-align: right;
        }
    </style>

    <body>
        @if (count($data) > 0)
        <h4 style="text-align:center">LAPORAN PRODUKSI PRODUK TURUNAN</h4>  
        <p style="margin-bottom: 3rem;">Periode : {{ date_format(date_create($tgl_awal),'d/M/Y').' - '.date_format(date_create($tgl_akhir),'d/M/Y') }}</p>
        
        <table class="mytable" style="width:100%">
            <tr>
                <td class="tdhead">No</td>
                <td class="tdhead">Nama Barang</td>
                <td class="tdhead">Tanggal</td>
                <td class="tdhead">Keterangan</td>
                <td class="tdhead">NoTicket</td>
                <td class="tdhead">Mutu Beton</td>
                <td class="tdhead">Jumlah Ticket</td>
                <td class="tdhead">Jumlah</td>
                <td class="tdhead">Hpp</td>
                <td class="tdhead">Subtotal</td>
            </tr>
            @php
                $total=0;
                $totalticket=0;
            @endphp
            @foreach($data as $index => $item)
            <tr>
                <td>{{ ++$index }}</td>
                <td>{{ $item->nama_barang }}</td>
                <td>{{ date_format(date_create($item->tanggal),'d/m/Y') }}</td>
                <td>{{ $item->keterangan }}</td>
                <td>{{ $item->noticket }}</td>
                <td>{{ $item->deskripsi }}</td>
                <td class="text-right">{{ number_format($item->jumlah_ticket,4,'.',',') }} </td>
                <td class="text-right">{{ number_format($item->jumlah,0,'.',',').' '.$item->satuan }} </td>
                <td class="text-right">{{ number_format($item->hpp,4,'.',',') }}</td>
                <td class="text-right">{{ number_format($item->hpp*$item->jumlah,4,'.',',') }}</td>
            </tr>
                @php
                    $total = $total + $item->hpp*$item->jumlah;
                    $totalticket = $totalticket + $item->jumlah_ticket;
                @endphp
                <tr>
                    <td colspan="10">
                        <table class="mytable" style="margin-left:10%;width:90%">
                            <tr>
                                <td>No</td>
                                <td>Nama Barang</td>
                                <td class="text-right">Jumlah</td>
                                <td class="text-right">Hpp</td>
                                <td class="text-right">Subtotal</td>
                            </tr>
                            @php
                                $z =0;
                            @endphp
                        @foreach($details->where('m_produksi_id',$item->id) as $detail)
                            <tr>
                                <td>{{ ++$z }}</td>
                                <td>{{ $detail->nama_barang }}</td>
                                <td class="text-right">{{ number_format($detail->jumlah,2,",",".") }}</td>
                                <td class="text-right">{{ number_format($detail->hpp,2,",",".") }}</td>
                                <td class="text-right">{{ number_format($detail->hpp*$detail->jumlah,2,",",".") }}</td>
                            </tr>
                        @endforeach
                        </table>
                    </td>    
                </tr>
            @endforeach 
            <tr>
                <td colspan="6" style="font-weight:bold">Total</td>
                <td class="text-right" style="font-weight:bold">{{ number_format($totalticket,4,',','.') }}</td>
                <td colspan="2"></td>
                <td class="text-right" style="font-weight:bold">{{ number_format($total,4,',','.') }}</td>
                
            </tr>
        </table>
        @endif
    </body>

</html>