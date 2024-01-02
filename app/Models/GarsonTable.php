<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\{Model,SoftDeletes};

class GarsonTable extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'garson_tables';
    protected $primaryKey = 'id';
    protected $fillable = [
        'user_id',
        'table',
        'start',
        'end',
        'starttime',
        'endtime',
        'company_id',
        'status',

    ];


    
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    protected $casts = [
        'table'=>'array'
    ];
}
