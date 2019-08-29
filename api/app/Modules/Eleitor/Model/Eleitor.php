<?php

namespace App\Modules\Eleitor\Model;

use App\Modules\Conta\Model\Usuario;
use Illuminate\Database\Eloquent\Model;

class Eleitor extends Model
{
    protected $table = 'tb_eleitor';
    protected $primaryKey = 'co_eleitor';
    protected $dateFormat = 'Y-m-d H:i:s.u';

    protected $dates = [
        'dt_nascimento',
        'dh_cadastro'
    ];

    protected $fillable = [
        'nu_cpf',
        'ds_email',
        'no_nome',
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

    public function getNacionalidadeAttribute()
    {
        return ($this->st_estrangeiro === true) ? 'Estrangeiro' : 'Brasileiro';
    }

    public function usuario()
    {
        return $this->hasOne(
            Usuario::class,
            'co_usuario',
            'co_usuario'
        );
    }
}
