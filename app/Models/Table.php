<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\{CartLocal};

class Table extends Model
{
    use HasFactory,SoftDeletes;

    protected $tbale = 'tables';
    protected $fillable = [
        'number',
        'location',
        'status',
        'is_assigned',
        'company_id',
        'user_id',
        'company_id',
        

    ];

   
    public function cartlocal()
    {
        return $this->hasMany(CartLocal::class,'table_id', 'id');
    }
}
