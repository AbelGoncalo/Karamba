<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\{Model,SoftDeletes};
use App\Models\Delivery;
class DeliveryDetail extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = "delivery_details";
    protected $primaryKey = "id";
    protected $guarded = "id";
    protected $fillable = [
        "delivery_id",
        "item",
        "price",
        "quantity",
        'subtotal',
        'discount',
        'tax',
        'company_id',

       
     ];


    
     public function delivery()
     {
         return $this->hasMany(Delivery::class, 'delivery_id', 'id');
     }
}
