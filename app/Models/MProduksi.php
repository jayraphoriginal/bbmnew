<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MProduksi extends Model
{
    use HasFactory;
    protected $fillable =['barang_id','jumlah','hpp','keterangan'];
}
