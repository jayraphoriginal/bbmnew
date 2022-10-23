<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MSalesorder extends Model
{
    use HasFactory;
    protected $fillable =[
            'noso',
            'tgl_so',
            'nopo',
            'marketing',
            'pembayaran',
            'jatuh_tempo',
            'customer_id',
            'status_so',
        ];
}
