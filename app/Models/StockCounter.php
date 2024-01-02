<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\{Model,SoftDeletes};

class StockCounter extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';
    protected $table = 'stock_counters';
    protected $fillable = [
        'product_economate_id',
        'company_id',
        'totalquantity',
    ];

}
