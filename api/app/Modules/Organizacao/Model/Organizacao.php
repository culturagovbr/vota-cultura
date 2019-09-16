<?php

namespace App\Modules\Organizacao\Model;

use App\Modules\Conta\Model\Usuario;
use App\Modules\Localidade\Model\Endereco;
use App\Modules\Organizacao\Model\Criterio;
use App\Modules\Organizacao\Model\Segmento;
use App\Modules\Representacao\Model\Representante;
use Illuminate\Database\Eloquent\Model;
use App\Modules\Core\Helper\Telefone as TelefoneHelper;

class Organizacao extends Model
{
    protected $table = 'tb_organizacao';
    protected $primaryKey = 'co_organizacao';

    protected $fillable = [
        'nu_cnpj',
        'no_organizacao',
        'ds_email',
        'nu_telefone',
        'co_segmento',
        'co_usuario',
        'co_endereco',
        'co_representante',
        'ds_sitio_eletronico',
        'st_inscricao',
    ];

    public $timestamps = false;

    public function criterios()
    {
        return $this->belongsToMany(
            Criterio::class,
            'rl_organizacao_criterio',
            'co_organizacao',
            'co_criterio'
        )->as('rl_organizacao_criterio');
    }

    public function segmento()
    {
        return $this->belongsTo(
            Segmento::class,
            'co_segmento',
            'co_segmento'
        );
    }

    public function usuario()
    {
        return $this->belongsTo(
            Usuario::class,
            'co_usuario',
            'co_usuario'
        );
    }

    public function endereco()
    {
        return $this->hasOne(
            Endereco::class,
            'co_endereco',
            'co_endereco'
        );
    }

    public function representante()
    {
        return $this->hasOne(
            Representante::class,
            'co_representante',
            'co_representante'
        );
    }

    public function getTelefoneFormatadoAttribute()
    {
        return TelefoneHelper::adicionarMascara($this->nu_telefone);
    }

    public function obterCriteriosCostumizados()
    {
        $criteriosCostumizados = new \stdClass();
        foreach ($this->criterios()->get() as $criterio) {
            $criteriosCostumizados->{$criterio->tp_criterio} = $criterio->co_criterio;
        }
        return $criteriosCostumizados;
    }

    public function obterPontuacao()
    {
        $pontuacao = 0;
        foreach ($this->criterios()->get() as $criterio) {
            $pontuacao += $criterio->qt_pontuacao * $criterio->qt_peso;
        }
        return $pontuacao;
    }

}
