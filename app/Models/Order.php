<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory,SoftDeletes;

    protected $primaryKey = 'id';
    protected $table = 'orders';
    protected $fillable = [
        'table',
        'client',
        'identify',
        'paymenttype',
        'splitAccount',
        'firstvalue',
        'secondvalue',
        'divisorresult',
        'total',
        'status',
        'user_id',
        'totaltax',
        'totaldiscount',
        'file_receipt',
        'company_id',
        'reference',

    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

}
