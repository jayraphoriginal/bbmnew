<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BahanBakar extends Model
{
    use HasFactory;
    protected $fillable = ['bahan_bakar','harga_beli','harga_claim','satuan_id'];
}
