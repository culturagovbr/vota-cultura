<?php

namespace App\Modules\Organizacao\Model;

use App\Modules\Conta\Model\Usuario;
use App\Modules\Representacao\Model\RepresentanteArquivoAvaliacao;
use Illuminate\Database\Eloquent\Model;

class OrganizacaoHabilitacao extends Model
{
    const SITUACAO_AVALIACAO_INABILITADA = '0';
    const SITUACAO_AVALIACAO_HABILITADA_DESCLASSIFICADA = '1';
    const SITUACAO_AVALIACAO_HABILITADA_CLASSIFICADA = '2';
    const SITUACAO_AVALIACAO_HABILITADA = '3';

    protected $table = 'tb_organizacao_habilitacao';
    protected $primaryKey = 'co_organizacao_habilitacao';

    protected $dates = [
        'dh_avaliacao',
    ];

    protected $fillable = [
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

    public function representanteArquivoAvaliacao()
    {
        return $this->hasMany(
            RepresentanteArquivoAvaliacao::class,
            'co_organizacao_habilitacao',
            'co_organizacao_habilitacao'
        );
    }

    public function historico()
    {
        return $this->hasmany(
            OrganizacaoHabilitacaoHistorico::class,
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
