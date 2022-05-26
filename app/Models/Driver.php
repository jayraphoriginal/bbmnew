<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama_driver',
        'tmpt_lahir' ,
        'tgl_lahir' ,
        'alamat' ,
        'pendidikan_terakhir' ,
        'tgl_masuk' ,
        'agama' ,
        'status' ,
        'gol_darah' ,
        'nobpjstk' ,
        'nobpjskes' ,
        'notelp' ,
        'status_kerja'
    ];
}
