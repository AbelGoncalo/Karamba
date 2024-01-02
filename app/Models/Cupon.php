<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\{Model,SoftDeletes};
use App\Models\User;
class Cupon extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = "cupons";
    protected $primaryKey = "id";
    protected $guarded = "id";
    protected $fillable = [
        "code",
        "type",
        "value",
        "user_id",
        'status',
        'date',
        'times',
        'expirateDate',
        'company_id'
     ];


     public function user()
     {
         return $this->belongsTo(User::class, 'user_id', 'id');
     }

    
}
