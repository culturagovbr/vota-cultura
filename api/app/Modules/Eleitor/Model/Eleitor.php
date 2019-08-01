<?php

namespace App\Modules\Eleitor\Model;

use Illuminate\Database\Eloquent\Model;

class Eleitor extends Model
{
    protected $table = 'tb_eleitor';
    protected $primaryKey = 'co_eleitor';

    protected $dates = [
        'dt_nascimento',
    ];

    protected $fillable = [
        'nu_cpf',
        'ds_email',
        'no_eleitor',
        'nu_rg',
        'dt_nascimento',
        'st_estrangeiro',
        'co_ibge',
        'co_usuario',
    ];

    public $timestamps = false;

    public function uf()
    {
        return $this->hasOne(
            \App\Modules\Localidade\Model\Uf::class,
            'co_ibge',
            'co_ibge'
        );
    }

    public function arquivos()
    {
        return $this->belongsToMany(
            \App\Modules\Upload\Model\Arquivo::class,
            'rl_eleitor_arquivo',
            'co_eleitor',
            'co_arquivo'
        );
    }
}
