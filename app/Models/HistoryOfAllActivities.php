<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoryOfAllActivities extends Model
{
    use HasFactory;
    protected $table = 'history_of_all_activities';
    protected $primaryKey = 'id';
    protected $fillable = [
        'tipo_acao',
        'descricao',
        'responsavel',
        'compnany_id',
        'company_id'

    ];
}
