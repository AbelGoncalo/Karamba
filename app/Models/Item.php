<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Category;
class Item extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = [
        'barcode',
        'cost',
        'description',
        'price',
        'iva',
        'image',
        'category_id',
        'company_id',
        'quantity',
    ];

   



    public function category()
    {
        return $this->belongsTo(Category::class,'category_id','id');
    }

  

}
