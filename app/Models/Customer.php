<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    protected $fillable = ['nama_customer','npwp','alamat','notelp','nofax','nama_pemilik','jenis_usaha'];
}
