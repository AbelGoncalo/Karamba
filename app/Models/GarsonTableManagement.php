<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\{Model};

class GarsonTableManagement extends Model
{
    use HasFactory;
    protected $table = 'garson_table_management';
    protected $primaryKey = 'id';
    protected $fillable = [
        'garson_table_id',
        'table',
        'company_id'
    ];

  
    public function garsontable()
    {
        return $this->belongsTo(GarsonTable::class, 'garson_table_id', 'id');
    }
}
