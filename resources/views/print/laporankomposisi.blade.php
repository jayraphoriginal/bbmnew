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
        <table style="width: 100%;">
            <tr>
                <td class="tdhead">Mutu Beton</td>
                <td class="tdhead">Air</td>
                <td class="tdhead">Batu Pecah 1/1</td>
                <td class="tdhead">Batu Pecah 1/2</td>
                <td class="tdhead">Batu Pecah 2/3</td>
                <td class="tdhead">Pasir</td>
                <td class="tdhead">Semen</td>
            </tr>
            @foreach($data as $item)
            @php
                $isi = json_decode(json_encode($item), true);
            @endphp
            <tr>
                @foreach($isi as $td)
                    <td>{{ $td }}</td>
                @endforeach
            </tr>
            @endforeach
        </table>
        @endif
    </body>

</html>