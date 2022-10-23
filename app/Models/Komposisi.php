<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Komposisi extends Model
{
    use HasFactory;
    protected $fillable = [
        'mutubeton_id',
        'barang_id',
        'jumlah',
        'satuan_id'
    ];
}
