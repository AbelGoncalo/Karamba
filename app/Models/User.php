<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable,SoftDeletes;
    

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $table = 'users'; 
    protected $fillable = [
        'name',
        'lastname',
        'genre',
        'phone',
        'profile',
        'status',
        'photo',
        'email',
        'password',
        'acceptterms',
        'company_id',
        'company_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];



    public function cupon()
    {
        return $this->hasMany(Coupon::class, 'user_id', 'id');
    }

    public function garsontables()
    {
        return $this->hasMany(GarsonTable::class, 'user_id', 'id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class,'user_id','id');
    }
    public function saque()
    {
        return $this->hasMany(Saque::class,'user_id','id');
    }

}
