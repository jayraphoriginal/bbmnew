<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KomposisiTurunan extends Model
{
    use HasFactory;
    protected $table = 'komposisi_turunans';
    protected $fillable = [ 'produkturunan_id', 'barang_id', 'tipe', 'jumlah', 'satuan_id'];
}
