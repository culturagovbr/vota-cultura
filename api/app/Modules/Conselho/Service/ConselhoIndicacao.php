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

    public function __construct(ConselhoIndicacaoModel $model)
    {
        parent::__construct($model);
    }

    public function cadastrar(Collection $dados): ?Model
    {
        try {
            $this->getModel()->fill($dados->only(['co_conselho', 'nu_cpf_indicado']));
            $quantidadeMaximaIndicadosExcedida = $this->getModel()->quantidadeMaximaIndicadosExcedida();

            if ($quantidadeMaximaIndicadosExcedida) {
                throw new EParametrosInvalidos('O conselho já atingiu o limite de indicados.');
            }

            $indicacaoJaCadastrada = $this->getModel()->indicacaoJaCadastrada();

            if ($indicacaoJaCadastrada) {
                throw new EParametrosInvalidos(
                    'O indicado já está cadastrado.',
                    Response::HTTP_NOT_ACCEPTABLE
                );
            }

            return parent::cadastrar($dados);
        } catch (EParametrosInvalidos $queryException) {
            DB::rollBack();
            throw $queryException;
        }
    }
}
