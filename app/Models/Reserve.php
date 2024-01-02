<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\{Model,SoftDeletes};

class Reserve extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'reserves';
    protected $primaryKey = 'id';
    protected $fillable = [
        'client',
        'email',
        'datetime',
        'expiratedate',
        'clientCount',
        'company_id',
        'description',
        'company_id',
    ];
}
