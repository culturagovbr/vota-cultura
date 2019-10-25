<?php

namespace App\Modules\Conselho\Model;

use App\Modules\Core\Exceptions\EParametrosInvalidos;
use App\Modules\Core\Helper\CPF;
use App\Modules\Localidade\Model\Endereco;
use App\Modules\Upload\Model\Arquivo;
use Illuminate\Database\Eloquent\Model;

class ConselhoIndicacao extends Model
{
    const QUANTIDADE_MAXIMA_INDICADOS = 5;

    protected $table = 'tb_conselho_indicacao';

    protected $primaryKey = 'co_conselho_indicacao';

    protected $dateFormat = 'Y-m-d H:i:s.u';

    protected $dates = [
        'dt_nascimento_indicado',
        'dh_indicacao',
    ];

    protected $fillable = [
        'co_conselho',
        'nu_cpf_indicado',
        'no_indicado',
        'co_endereco',
        'dt_nascimento_indicado',
        'co_arquivo',
        'ds_curriculo',
        'dh_indicacao',
    ];

    public $timestamps = FALSE;

    public function endereco()
    {
        return $this->hasOne(
            Endereco::class,
            'co_endereco',
            'co_endereco'
        );
    }

    public function conselho()
    {
        return $this->belongsTo(
            Conselho::class,
            'co_conselho',
            'co_conselho'
        );
    }

    public function fotoUsuario()
    {
        return $this->hasOne(
            Arquivo::class,
            'co_arquivo',
            'co_arquivo'
        );
    }

    public function arquivos()
    {
        return $this->belongsToMany(
            Arquivo::class,
            'rl_conselho_indicacao_arquivo',
            'co_conselho_indicacao',
            'co_arquivo'
        )->as('rl_conselho_indicacao_arquivo')->withPivot(
            [
                'co_conselho_indicacao',
                'tp_arquivo',
            ]
        );
    }

    public function avaliacaoHabilitacao()
    {
        return $this->hasOne(
            ConselhoIndicacaoHabilitacao::class,
            'co_indicado',
            'co_conselho_indicacao'
        );
    }

    public function quantidadeMaximaIndicadosExcedida(): bool
    {
        if (empty($this->co_conselho)) {
            throw new EParametrosInvalidos('Identificador `co_conselho` não informado.');
        }

        $quantidade = $this->where($this->only('co_conselho'))->count();

        if ($quantidade < self::QUANTIDADE_MAXIMA_INDICADOS) {
            return false;
        }

        return true;
    }

    public function indicacaoJaCadastrada(): bool
    {
        if (empty($this->co_conselho)) {
            throw new EParametrosInvalidos('Identificador `co_conselho` não informado.');
        }

        if (empty($this->nu_cpf_indicado)) {
            throw new EParametrosInvalidos('Identificador `nu_cpf_indicado` não informado.');
        }

        $conselhoIndicado = $this->where($this->only('co_conselho', 'nu_cpf_indicado'))->first();

        if (empty($conselhoIndicado)) {
            return false;
        }

        return true;
    }

    public function getCpfIndicadoFormatadoAttribute()
    {
        return CPF::adicionarMascara($this->nu_cpf_indicado);
    }
}
