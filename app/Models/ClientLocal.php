<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent;
class ClientLocal extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';
    protected $table = 'client_locals';
    protected $fillable = [
        'client',
        'tableNumber',
        'clientCount',
        'user_id',
        'company_id',
    ];
}
