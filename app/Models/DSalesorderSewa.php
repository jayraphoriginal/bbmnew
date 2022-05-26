<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DSalesorderSewa extends Model
{
    use HasFactory;
    protected $fillable =[
        'm_salesorder_sewa_id',
        'itemsewa_id',
        'harga_intax',
        'lama',
        'satuan_id',
        'tgl_awal',
        'tgl_akhir',
        'status_detail',
        'user_id'
    ];
}
