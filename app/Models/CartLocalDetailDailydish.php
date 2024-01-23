<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartLocalDetailDailydish extends Model
{
    use HasFactory;
    protected $table = 'cart_local_detail_dailydishes';
    protected $primaryKey = 'id';
    protected $fillable = [
        'entrance',
        'maindish',
        'dessert',
        'drink',
        'coffe',
        'company_id',
        'cart_local_detail_id',
    ];
}
