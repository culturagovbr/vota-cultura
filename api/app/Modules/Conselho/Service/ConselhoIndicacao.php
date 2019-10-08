<?php

namespace App\Modules\Conselho\Service;

use App\Core\Service\AbstractService;
use App\Modules\Conselho\Model\ConselhoIndicacao as ConselhoIndicacaoModel;
use App\Modules\Core\Exceptions\EParametrosInvalidos;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class ConselhoIndicacao extends AbstractService
{
    const QTD_MAXIMO_INDICADOS = 5;

    public function __construct(ConselhoIndicacaoModel $model)
    {
        parent::__construct($model);
    }

    private function validarQuantidadeMaximaIndicados(array $dadosConselho)
    {
        $count = $this->getModel()
            ->where($dadosConselho)
            ->count();

        if ($count >= self::QTD_MAXIMO_INDICADOS) {
            throw new EParametrosInvalidos('O conselho já atingiu o limite de indicados.');
        }
    }

    private function verificarIndicadoCadastrado(array $verification)
    {
        $conselhoIndicacao = $this->getModel()
            ->where($verification)
            ->first();

        if ($conselhoIndicacao) {
            throw new EParametrosInvalidos(
                'O indicado já está cadastrado.',
                Response::HTTP_NOT_ACCEPTABLE
            );
        }
    }

    public function cadastrar(Collection $dados): ?Model
    {
        $this->validarQuantidadeMaximaIndicados($dados->only(['co_conselho'])->toArray());
        $this->verificarIndicadoCadastrado($dados->only(['co_conselho', 'nu_cpf_indicado'])->toArray());

        try {
            return parent::cadastrar($dados);
        } catch (EParametrosInvalidos $queryException) {
            DB::rollBack();
            throw $queryException;
        }
    }
}
