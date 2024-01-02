<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent;
use App\Models\{Table};

class CartLocal extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';
    protected $table = 'cart_locals';
    protected $fillable = [
        'table',
        'client_local_id',
        'user_id',
        'company_id',
    ];


   
    public function carlocaldetail()
    {
        return $this->hasMany(CartLocalDetail::class, 'cart_local_id', 'id');
    }
}
