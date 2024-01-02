<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DetailOrder extends Model
{
    use HasFactory,SoftDeletes;

    protected $primaryKey = 'id';
    protected $table = 'detail_orders';
    protected $fillable = [
        'order_id',
        'item',
        'price',
        'quantity',
        'subtotal',
        'tax',
        'discount',
        'company_id',

    ];
}
