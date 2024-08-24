<html>

    <head>
       <title>Laporan Komposisi</title>
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
        table{
            border-collapse: collapse;
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
        
        <h4 style="text-align:center">LAPORAN KOMPOSISI</h4>
        
        @if (count($data) > 0)
        <table class="mytable" style="width: 100%;">
            <tr>
                <td class="tdhead">No</td>
                <td class="tdhead">Mutu Beton</td>
                <td class="tdhead">Status</td>
                <td class="tdhead">Tgl Berlaku </td>
                <td class="tdhead text-right">Admiture</td>
                <td class="tdhead text-right">Air</td>
                <td class="tdhead text-right">Batu Pecah 1/1</td>
                <td class="tdhead text-right">Batu Pecah 1/2</td>
                <td class="tdhead text-right">Batu Pecah 2/3</td>
                <td class="tdhead text-right">Pasir</td>
                <td class="tdhead text-right">Semen</td>
            </tr>
            @foreach($data as $index => $item)
            @php
                $isi = json_decode(json_encode($item), true);
            @endphp
            @if ($item->status == 'aktif')
                <tr>
            @else
                <tr style="background-color: #ccc;">
            @endif
                <td>{{ ++$index }}</td>
                @php
                    $z = 1;
                @endphp
                @foreach($isi as $td)
                    @if ($z >=4)
                        <td class="text-right">{{ $td }}</td>
                    @else
                        <td>{{ $td }}</td>
                    @endif
                    @php
                        $z++;
                    @endphp
                @endforeach
            </tr>
            @endforeach
        </table>
        @endif
    </body>

</html>