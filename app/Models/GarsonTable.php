<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\{Model};

class GarsonTable extends Model
{
    use HasFactory;
    protected $table = 'garson_tables';
    protected $primaryKey = 'id';
    protected $fillable = [
        'user_id',
        'start',
        'end',
        'starttime',
        'endtime',
        'company_id',
        'status',
        'table',

    ];


    
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

 

    public function garsontablemanagement()
    {
        return $this->hasMany(GarsonTableManagement::class, 'garson_table_id', 'id');
    }
}
