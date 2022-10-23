<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DSalesorder extends Model
{
    use HasFactory;
    protected $fillable =[
        'm_salesorder_id',
        'rate_id',
        'jarak_tempuh_id',
        'tipe',
        'mutubeton_id',
        'harga_intax',
        'jumlah',
        'sisa',
        'satuan_id',
        'tgl_awal',
        'tgl_akhir',
        'status_detail',
        'user_id'
    ];
}
