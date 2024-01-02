<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
//use Illuminate\Database\Eloquent\{Model,SoftDeletes};
use Illuminate\Database\Eloquent\{Model};
use App\Models\DeliveryDetail;
class Delivery extends Model
{
    use HasFactory;
    // use HasFactory,SoftDeletes;
    protected $table = "deliveries";
    protected $primaryKey = "id";
    protected $guarded = "id";
    protected $fillable = [
        "total",
        "discount",
        "locationprice",
        "customername",
        'customerlastname',
        'customerprovince',
        'customermunicipality',
        'customerstreet',
        'customerphone',
        'customerotherphone',
        'customerpaymenttype',
        'receipt',
        'finddetail',
        'customerotheraddress',
        'company_id',
     ];


     
     public function deliveries()
     {
         return $this->belongsTo(DeliveryDetail::class, 'delivery_id', 'id');
     }

}
