<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyDish extends Model
{
    use HasFactory;
    protected $table = "daily_dishes";
    protected $primaryKey = "id";
    protected $fillable = [       
        "entrance",
        "maindish",
        "dessert", 
        "drink", 
        "coffe", 
        "company_id",
        "item_id",
    ];

   // public $timestamps = false;

   protected $casts = [
    'entrance' => 'array',
    'maindish' => 'array',
    'dessert' => 'array',
    'drink' => 'array',
    'coffe' => 'array',
];

    public function itemsRelationship(){
        return $this->belongsTo(Item::class);
    }
}
