<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produkturunan extends Model
{
    use HasFactory;
    protected $table = 'produk_turunan';
    protected $fillable = [ 'deskripsi', 'jumlah', 'satuan_id', 'barang_id'];
}
