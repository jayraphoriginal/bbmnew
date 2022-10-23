<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DProduksi extends Model
{
    use HasFactory;
    protected $fillable =['barang_id','jumlah','hpp'];
}
