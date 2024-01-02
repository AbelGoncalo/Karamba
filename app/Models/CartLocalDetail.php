<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\{Model};

class CartLocalDetail extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';
    protected $table = 'cart_local_details';
    protected $fillable = [
        'cart_local_id',
        'name',
        'price',
        'quantity',
        'status',
        'category',
        'company_id',
        'table',


    ];

    public function cartlocal()
    {
        return $this->belongsTo(CartLocal::class, 'cart_local_id', 'id');
    }
}
