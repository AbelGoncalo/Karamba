<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\{Model,SoftDeletes};

class NotificationGarson extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'notification_garsons';
    protected $primaryKey = 'id';
    protected $fillable = [
        'company_companyid',
        'garson_table_id',
        'title',
        'message',
        'status',
        'paymentid',
        'tableNumber',
        'company_id',

    ];
}
