<?php

namespace App\Modules\Fase\Model;

use Illuminate\Database\Eloquent\Model;

class Fase extends Model
{
    protected $table = 'tb_fase';
    protected $primaryKey = 'co_fase';

    protected $dates = [
        'dh_inicio',
        'dh_fim',
    ];

    protected $fillable = [
        'tp_fase',
        'dh_inicio',
        'dh_fim',
    ];

    public $timestamps = false;
}
