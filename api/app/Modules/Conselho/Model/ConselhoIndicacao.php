<?php

namespace App\Modules\Conselho\Model;

use App\Modules\Core\Exceptions\EParametrosInvalidos;
use App\Modules\Localidade\Model\Endereco;
use Illuminate\Database\Eloquent\Model;

class ConselhoIndicacao extends Model
{
    const QUANTIDADE_MAXIMA_INDICADOS = 5;

    protected $table = 'tb_conselho_indicacao';
    protected $primaryKey = 'co_conselho_indicacao';
    protected $fillable = [
        'co_conselho',
        'nu_cpf_indicado',
        'no_indicado',
        'co_endereco',
    ];

    public $timestamps = false;

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
}
