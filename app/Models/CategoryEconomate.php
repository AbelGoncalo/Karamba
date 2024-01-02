<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\{Model,SoftDeletes};

class CategoryEconomate extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'description',
        'company_id',

    ];
    protected $table = 'category_economates';
    protected $primaryKey = 'id';

    public function products()
    {
        return $this->hasMany(ProductEconomate::class, 'category_economate_id', 'id');
    }
}
