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
        "menutype", "entrance",
         "dessert", 
         "maindish",
          "drink", 
          "coffe", 
          "company_id",
           "item_id",
    ];

    public $timestamps = false;
}
