<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mpajak extends Model
{
    use HasFactory;
    protected $fillable=['jenis_pajak','persen','coa_id_debet','coa_id_kredit'];
}
