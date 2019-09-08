<?php

namespace App\Modules\Fase\Model;

use App\Modules\Core\Exceptions\EPropriedadeNaoDefinida;
use Illuminate\Database\Eloquent\Model;

class Fase extends Model
{
    const ABERTURA_INSCRICOES_CONSELHO = 'abertura_inscricoes_conselho';
    const ABERTURA_INSCRICOES_ORGANIZACAO = 'abertura_inscricoes_organizacao';
    const ABERTURA_INSCRICOES_ELEITOR = 'abertura_inscricoes_eleitor';
    const RECURSO_INSCRICOES_CONSELHO = 'recurso_inscricoes_conselho';
    const RECURSO_INSCRICOES_ORGANIZACAO = 'recurso_inscricoes_organizacao';

    protected $table = 'tb_fase';
    protected $primaryKey = 'co_fase';

    protected $dates = [
        'dh_inicio',
        'dh_fim',
    ];

    protected $fillable = [
        'tp_fase',
        'ds_detalhamento',
        'dh_inicio',
        'dh_fim',
    ];

    public $timestamps = false;

    public function faseFinalizada() : bool
    {
        if(empty($this->dh_fim)) {
            throw new EPropriedadeNaoDefinida('Propriedade `dh_fim` não definida.');
        }
        $dataAtual = \Illuminate\Support\Carbon::now();
        return $dataAtual->greaterThan($this->dh_fim);
    }
}
