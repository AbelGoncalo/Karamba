<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\{Model,SoftDeletes};

class Compartment extends Model
{
    use HasFactory,SoftDeletes;

      protected $primaryKey = 'id';
    protected $table = 'compartments';
    protected $fillable = [
        'description',
        'company_id',
    ];
}
