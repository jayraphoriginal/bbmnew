<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TmpKartuStok extends Model
{
    use HasFactory;
    protected $table='tmp_kartu_stok';
    public $timestamps = false;
}
