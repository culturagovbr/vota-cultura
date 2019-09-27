<?php

namespace App\Modules\Organizacao\Model;

use App\Modules\Representacao\Model\RepresentanteArquivoAvaliacao;
use Illuminate\Database\Eloquent\Model;

class OrganizacaoHabilitacao extends Model
{
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
}