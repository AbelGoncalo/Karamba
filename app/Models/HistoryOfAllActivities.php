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
<<<<<<< HEAD
        'compnany_id',
=======
        'company_id'
>>>>>>> e9a451259d67950ba865218ea97152a9bd1b8246
    ];
}
