<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mutubeton extends Model
{
    use HasFactory;
    protected $fillable = [ 'kode_mutu', 'jumlah', 'satuan_id', 'berat_jenis'];
}
