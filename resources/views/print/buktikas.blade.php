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
        <p style="float:right">D/C No.</p>
        <p style="font-style:italic;margin-bottom:5px;">Sudah Diterima Dari :</p>
        <hr style="margin-bottom:8px;">
        <div style="display:inline-block;margin-right:8px;">
            <input type="checkbox" {{ $data->tipe=='cash' ? 'checked' : '' }}>
            <label >TUNAI</label>
        </div>
        <div style="display:inline-block;margin-right:8px;">
            <input type="checkbox" {{ $data->tipe=='transfer' ? 'checked' : '' }}>
            <label>KU</label>
        </div>
        <div style="display:inline-block;margin-right:8px;">
            <input type="checkbox" {{ $data->tipe=='cheque' || $data->tipe=='giro' ? 'checked' : '' }}>
            <label>CEK/GIRO No.{{ $data->nowarkat }}</label>
        </div>
        <div style="float:right;display:inline-block">TGL {{ date_create($data->tgl_bayar)->format('d F Y')}}</div>
        <div style="margin-left:10em">BANK {{ $data->tipe== 'transfer' ? $data->nama_bank.' '.$data->norek : ''}}</div>
        <p>Rp. {{ number_format($data->jumlah,2,',','.') }}</p>
        <table style="margin-top:5px;margin-bottom:6em;width:100%">
            <tr>
                <td style="height:40px;width:20%">Terbilang</td>
                <td>{{ ucwords($terbilang).' Rupiah' }}</td>
            </tr>
            <tr>
                <td style="height:40px;width:20%">Untuk Keperluan </td>
                <td>{{ $data->keterangan }}</td>
            </tr>
        </table>
        <table style="width:100%">
            <tr>
                <td style="border:1px solid;text-align:center;width:20%">Kadiv</td>
                <td style="border:1px solid;text-align:center;width:20%">Pembukuan</td>
                <td style="border:1px solid;text-align:center;width:20%">Kasir</td>
                <td style="padding-left:8px;">Tgl, {{ date_create($data->tgl_bayar)->format('d F Y')}}</td>
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