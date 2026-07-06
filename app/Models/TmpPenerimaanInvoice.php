<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TmpPenerimaanInvoice extends Model
{
    use HasFactory;
    protected $table = 'tmp_penerimaan_invoice';
    public $timestamps = false;
}
