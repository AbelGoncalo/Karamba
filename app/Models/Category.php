<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Item;

class Category extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'description',
        'company_id',
    ];


    
    public function items()
    {
        return $this->hasMany(Item::class, 'category_id', 'id');
    }
  
}
