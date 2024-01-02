<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\{Model,SoftDeletes};

class ProductEconomate extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'description',
        'image',
        'cost',
        'company_id',
        'category_economate_id',
        'fixe_price',
        'unit',
        'category_economate_id',
        'company_id',
    ];
    protected $table = 'product_economates';
    protected $primaryKey = 'id';

    public function category_economato()
    {
        return $this->belongsTo(CategoryEconomate::class,'category_economate_id','id');
    }

  

    public function products()
    {
        return $this->hasMany(StockEnter::class, 'product_economate_id', 'id');
    }


    public function stockout_product()
    {
        return $this->hasMany(StockOut::class, 'product_economate_id', 'id');
    }
    
}
