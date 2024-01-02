<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\{Model,SoftDeletes};

class Location extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'location',
        'price',
        'company_id',
        
    ];
}
