<?php

namespace App\Modules\Avaliacao\Model;

use Illuminate\Database\Eloquent\Model;

class Criterio extends Model
{
    protected $table = 'tb_criterio';
    protected $primaryKey = 'co_criterio';

    protected $fillable = [
        'tp_criterio',
        'ds_criterio',
        'ds_detalhamento',
        'qt_pontuacao',
        'qt_peso',
    ];

    public $timestamps = false;

}