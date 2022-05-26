<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Itemsewa extends Model
{
    use HasFactory;
    protected $fillable = ['nama_item','harga_intax','satuan_id'];
}
