<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankAccount extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    protected $table = 'bank_accounts';
    protected $fillable = [
        'bank',
        'ibam',
        'number',
        'email',
        'company_id',
    ];
}
