<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\{Model,SoftDeletes};

class StockOut extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'stock_outs';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
    protected $fillable = [
        'quantity',
        'usetype',
        'chef',
        'unit',
        'description',
        'product_economate_id',
        'company_id',
        'user_id',
        'stockenter_id',
        'company_id',
        'from',
        'to',
    

    ];

    public function product_economate()
    {
        return $this->belongsTo(ProductEconomate::class,'product_economate_id','id');
    }
}
