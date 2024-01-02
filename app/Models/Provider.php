<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\{Model,SoftDeletes};

class Provider extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'providers';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name',
        'phone',
        'alternativephone',
        'email',
        'nif',
        'address',
        'company_id',
    ];
}
