<?php

namespace App\Modules\Organizacao\Model;

use App\Modules\Conta\Model\Usuario;
use Illuminate\Database\Eloquent\Model;

class OrganizacaoHabilitacaoHistorico extends Model
{
    protected $table = 'tb_organizacao_habilitacao_historico';
    protected $primaryKey = 'co_organizacao_habilitacao_historico';

    protected $dates = [
        'dh_avaliacao',
    ];

    protected $fillable = [
        'co_organizacao_habilitacao',
        'co_organizacao',
        'st_avaliacao',
        'ds_parecer',
        'dh_avaliacao',
        'nu_nova_pontuacao',
        'co_usuario_avaliador',
    ];

    public $timestamps = FALSE;

    public function organizacao()
    {
        return $this->hasOne(
            Organizacao::class,
            'co_organizacao',
            'co_organizacao'
        );
    }

    public function habilitacao()
    {
        return $this->hasOne(
            OrganizacaoHabilitacao::class,
            'co_organizacao_habilitacao',
            'co_organizacao_habilitacao'
        );
    }

    public function usuarioAvaliador()
    {
        return $this->hasOne(Usuario::class,
            'co_usuario',
            'co_usuario_avaliador'
        );
    }
}
