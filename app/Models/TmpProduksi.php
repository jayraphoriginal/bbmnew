<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TmpProduksi extends Model
{
    use HasFactory;
    protected $fillable =['barang_id','jumlah'];

}
