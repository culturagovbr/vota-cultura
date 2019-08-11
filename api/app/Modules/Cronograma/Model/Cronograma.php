<?php

namespace App\Modules\Cronograma\Model;

use Illuminate\Database\Eloquent\Model;

class Cronograma extends Model
{
    protected $table = 'tb_cronograma';
    protected $primaryKey = 'co_cronograma';

    protected $dates = [
        'dh_inicio',
        'dh_fim',
    ];

    protected $fillable = [
        'tp_cronograma',
        'dh_inicio',
        'dh_fim',
    ];

    public $timestamps = false;
}
