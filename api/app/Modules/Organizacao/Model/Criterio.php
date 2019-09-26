<?php

namespace App\Modules\Organizacao\Model;

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

    public $timestamps = FALSE;

    public function organizacoes ()
    {
        return $this->belongsToMany(
            \App\Modules\Organizacao\Model\Organizacao::class,
            'rl_organizacao_criterio',
            'co_organizacao',
            'co_criterio'
        )->as('rl_organizacao_criterio');
    }

}
