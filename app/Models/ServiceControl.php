<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceControl extends Model
{
    use HasFactory;
    protected $table ='service_controls';
    protected $primaryKey ='id';
    protected $fillable =[
        'item',
        'time',
        'company_id',
    ];
}
