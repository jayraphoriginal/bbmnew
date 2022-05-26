<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DPurchaseorder extends Model
{
    use HasFactory;
    protected $fillable = [
        'm_purchaseorder_id',
        'barang_id',
        'jumlah',
        'satuan_id',
        'harga',
        'status_detail',
        'user_id'
    ];
}
