<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kendaraan extends Model
{
    use HasFactory;
    protected $fillable = ['nopol',
        'nama_pemilik',
        'alamat' ,
        'tipe' ,
        'model' ,
        'tahun_pembuatan' ,
        'warnakb' ,
        'berlaku_sampai' ,
        'berlaku_kir' ,
        'tgl_perolehan' ,
        'siu' ,
        'muatan' ,
        'loading',
        'driver_id'
    ];
}
