<?php

namespace App\Modules\Upload\Models;

use Illuminate\Database\Eloquent\Model;

class Arquivo extends Model
{
    protected $table = 'tb_arquivo';
    protected $primaryKey = 'co_arquivo';

    protected $fillable = [
        'no_arquivo',
        'ds_localizacao',
    ];

    protected $date = [
        'dh_criacao'
    ];

    public $timestamps = false;

    public function representantes()
    {
        return $this->belongsToMany(
            \App\Modules\Representacao\Model\Representante::class,
            'rl_representante_arquivo',
            'co_representante',
            'co_arquivo'
        )->as('rl_representante_arquivo')
            ->withPivot(
                [
                    'tp_arquivo',
                    'tp_inscricao'
                ]
            );
    }
}
