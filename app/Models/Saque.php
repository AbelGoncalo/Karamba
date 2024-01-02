<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Saque extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';
    protected $table = 'saques';
    protected $fillable = [
        'user_id',
        'company_id',
        'value',
        'date',
        'description',
    ];

    public function userSaque(){
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function userRelacionamento(){
        return $this->belongsTo(User::class, 'id');
    }
}
