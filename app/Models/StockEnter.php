<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockEnter extends Model
{
    use HasFactory;
    protected $table = 'stock_enters';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
    protected $fillable = [
        'quantity',
        'description',
        'price',
        'unit_price',
        'unit',
        'source_product',
        'source',
        'product_economate_id',
        'company_id',
        'user_id',
        'expiratedate',
        'company_id',
    ];

    public function product()
    {
        return $this->belongsTo(ProductEconomate::class,'product_economate_id','id');
    }
   
}
