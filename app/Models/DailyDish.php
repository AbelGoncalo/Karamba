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
        "dessert", 
        "maindish",
        "drink", 
        "coffe", 
        "company_id",
        "item_id",
    ];

    public $timestamps = false;

    public function itemsRelationship(){
        return $this->belongsTo(Item::class);
    }
}
