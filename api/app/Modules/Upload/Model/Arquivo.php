<?php

namespace App\Modules\Upload\Model;

use App\Modules\Conselho\Model\ConselhoIndicacaoArquivo;
use App\Modules\Conselho\Model\ConselhoIndicacao;
use Illuminate\Database\Eloquent\Model;

class Arquivo extends Model
{
    protected $table = 'tb_arquivo';
    protected $primaryKey = 'co_arquivo';

    protected $fillable = [
        'no_arquivo',
        'ds_localizacao',
        'no_extensao',
        'no_mime_type',
    ];

    protected $date = [
        'dh_criacao'
    ];

    public $timestamps = FALSE;

    protected $stringCodificada;
    protected $diretorioArmazenamento = '';

    public function representantes()
    {
        return $this->belongsToMany(
            \App\Modules\Representacao\Model\Representante::class,
            'rl_representante_arquivo',
            'co_representante',
            'co_arquivo'
        )->as('rl_representante_arquivo')->withPivot('tp_arquivo', 'tp_inscricao');
    }

    public function eleitores()
    {
        return $this->belongsToMany(
            \App\Modules\Eleitor\Model\Eleitor::class,
            'rl_eleitor_arquivo',
            'co_eleitor',
            'co_arquivo'
        )->withPivot(['tp_arquivo']);
    }

    public function arquivoIndicacao()
    {
        return $this->belongsToMany(
            \App\Modules\Conselho\Model\ConselhoIndicacao::class,
            'rl_conselho_indicacao_arquivo',
            'co_arquivo',
            'co_conselho_indicacao',
        )->as('rl_conselho_indicacao_arquivo')->withPivot('tp_arquivo', 'co_conselho_indicacao');
    }
}
