<html>

    <head>
        <style>
            *{
                margin:0;
                padding:0;
                font-size:12px;
                font-weight:bold;
            }
            table{
                margin:0rem;
                border-collapse: collapse;
            }
            @page{
                margin: 0.1in 0.1in 0.1in 0.1in;
            }
            label {
                display: inline;
            }
            input[type=checkbox] {
                display: inline;
            }
        </style>
        <title>BUKTI KAS</title>
    </head>

    <body style="padding:2em">
        <h3 style="text-align:center; font-size:16px">BUKTI KAS</h3>
        <p style="float:right">D/C No. {{ $data[0]->nobuktikas }}</p>
        <p style="font-style:italic;margin-bottom:5px;">Sudah Diterima Dari :</p>
        <hr style="margin-bottom:8px;">
        <div style="display:inline-block;margin-right:8px;">
            <input type="checkbox" {{ $data[0]->tipe_pembayaran=='cash' ? 'checked' : '' }}>
            <label >TUNAI</label>
        </div>
        <div style="display:inline-block;margin-right:8px;">
            <input type="checkbox" {{ $data[0]->tipe_pembayaran=='transfer' ? 'checked' : '' }}>
            <label>KU</label>
        </div>
        <div style="display:inline-block;margin-right:8px;">
            <input type="checkbox" {{ $data[0]->tipe_pembayaran=='cheque' || $data[0]->tipe_pembayaran=='kredit' || $data[0]->tipe_pembayaran=='giro' ? 'checked' : '' }}>
            <label>CEK/GIRO No.{{ $data[0]->nowarkat }}</label>
        </div>
        <div style="float:right;display:inline-block">TGL {{ date_create($data[0]->tgl_bayar)->format('d F Y')}}</div>
        @if ($data[0]->tipe_pembayaran!='cash')
            <div>BANK {{ $data[0]->nama_bank.' '.$data[0]->norek}}</div>
        @else
            <div>BANK</div>
        @endif
        <p>Rp. {{ number_format($data[0]->total,2,',','.') }}</p>
        <table style="margin-top:5px;margin-bottom:6em;width:100%">
            <tr>
                <td style="height:40px;width:20%">Terbilang</td>
                <td>{{ ucwords($terbilang).' Rupiah' }}</td>
            </tr>
            <tr>
                <td style="height:40px;width:20%">Untuk Keperluan </td>
                @if(is_null($data[0]->ket) || $data[0]->ket =='')
                    <td>
                        @foreach($data as $key => $value)
                            @if($key == 0)
                                {{ ' '.$value->keterangan }}
                            @else
                                {{ ' ,'.$value->keterangan }}
                            @endif
                        @endforeach
                    </td>
                @else
                    <td>{{$data[0]->ket}}</td>
                @endif
            </tr>
        </table>
        <table style="width:100%">
            <tr>
                <td style="border:1px solid;text-align:center;width:20%">Kadiv</td>
                <td style="border:1px solid;text-align:center;width:20%">Pembukuan</td>
                <td style="border:1px solid;text-align:center;width:20%">Kasir</td>
                <td style="padding-left:8px;">Tgl, {{ date_create($data[0]->tgl_bayar)->format('d F Y')}}</td>
            </tr>
            <tr>
                <td style="border:1px solid;height:50px"></td>
                <td style="border:1px solid;"></td>
                <td style="border:1px solid;"></td>
                <td style="padding-left:8px;vertical-align:top">Penerima</td>
            </tr>
        </table>
        
    </body>

</html>