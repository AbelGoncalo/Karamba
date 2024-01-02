<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\{Model,SoftDeletes};

class Review extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = "reviews";
    protected $primaryKey = "id";
    protected $fillable = [
        "star_number",
        "comment",
        "date",
        "status",
        "product_id",
        "user_id",
        'company_id',
        'site',
        'item',
    ];


    public function company()
    {
        return $this->belongsTo(Company::class,'company_id','id');
    }
}
