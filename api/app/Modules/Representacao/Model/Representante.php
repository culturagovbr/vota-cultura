<?php

namespace App\Modules\Representacao\Model;

use App\Modules\Conselho\Model\Conselho;
use App\Modules\Core\Helper\Telefone as TelefoneHelper;
use App\Modules\Organizacao\Model\Organizacao;
use App\Modules\Upload\Model\Arquivo;
use Illuminate\Database\Eloquent\Model;


class Representante extends Model
{
    const TIPO_INSCRICAO_ORGANIZACAO = 1;
    const TIPO_INSCRICAO_CONSELHO = 2;

    protected $table = 'tb_representante';
    protected $primaryKey = 'co_representante';
    protected $dateFormat = 'Y-m-d H:i:s.u';

    protected $dates = [
        'dh_cadastro'
    ];

    protected $fillable = [
        'dh_cadastro',
        'ds_email',
        'no_nome',
        'nu_rg',
        'nu_cpf',
        'nu_telefone',
    ];

    public $timestamps = false;

    public function organizacao()
    {
        return $this->hasOne(
            Organizacao::class,
            'co_representante',
            'co_representante'
        );
    }

    public function conselho()
    {
        return $this->hasOne(
            Conselho::class,
            'co_representante',
            'co_representante'
        );
    }

    public function arquivos()
    {
        return $this->belongsToMany(
            Arquivo::class,
            'rl_representante_arquivo',
            'co_representante',
            'co_arquivo'
        );
    }

    public function representacaoArquivoAvaliacao()
    {
        return $this->arquivos()->hasMany(
            RepresentanteArquivoAvaliacao::class,
            'co_representante_arquivo',
            'co_representante_arquivo'
        );
    }

    public function arquivosAvaliados()
    {
        return $this->hasManyThrough(
            RepresentanteArquivoAvaliacao::class,
            RepresentanteArquivoPivot::class,
            'co_representante',
            'co_representante_arquivo',
            '',
            'co_representante_arquivo'
        );
    }

    public function getTelefoneFormatadoAttribute()
    {
        return TelefoneHelper::adicionarMascara($this->nu_telefone);
    }
}
