<?php

namespace App\Modules\Conselho\Service;

use App\Core\Service\AbstractService;
use App\Modules\Conselho\Model\ConselhoVotacao as ConselhoVotacaoModel;
use App\Modules\Core\Exceptions\EValidacaoCampo;
use App\Modules\Eleitor\Model\Eleitor;
use App\Modules\Pessoa\Service\Receita;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;


class ConselhoVotacao extends AbstractService
{

    public function __construct(ConselhoVotacaoModel $model)
    {
        if (!empty(auth()->user())) {
            $this->usuario = auth()->user()->dadosUsuarioAutenticado();
        }
        parent::__construct($model);
    }

    public function registrarVoto(Collection $dados): ?Model
    {
        try {
            DB::beginTransaction();

            $this->verificarSeEleitorPodeVotar();
            $this->verificarNomeMaeReceita($dados['nomeMae']);
            $eleitorCriado = parent::cadastrar(collect([
                'co_conselho_indicacao' => (int) $dados['co_conselho_indicacao'],
                'co_eleitor' => $this->usuario['co_eleitor']
            ]));

            DB::commit();
            return $eleitorCriado;
        } catch (\HttpException $queryException) {
            DB::rollBack();
            throw $queryException;
        }
    }

    private function verificarNomeMaeReceita(string $nomeMae)
    {
        $nomeMae = strtoupper($nomeMae);
        $receitaService = app(Receita::class);
        $dadosReceita = $receitaService->consultarDadosPessoaFisica($this->usuario['nu_cpf']);

        if ($dadosReceita['nmMae'] !== strtoupper(Str::ascii($nomeMae)) && !empty($dadosReceita['nmMae'])) {
            throw new EValidacaoCampo('O nome da mãe não confere, tente novamente!');
        }
    }

    private function verificarSeEleitorPodeVotar(): bool
    {
        $eleitor = (new Eleitor)->where([
            'co_eleitor' => $this->usuario['co_eleitor'],
        ])->get();

        if ($eleitor->isEmpty()) {
            throw new EValidacaoCampo('O usuario logado não é um eleitor!');
        }

        if ($eleitor->first()->dt_nascimento->age < 18) {
            throw new EValidacaoCampo('O eleitor não possui a idade mínima permitida!');
        }


        if ($eleitor->first()->st_estrangeiro === TRUE) {
            throw new EValidacaoCampo('O usuario logado é estrangeiro!');
        }

        $eleitorJaVotou = !$this->getModel()->where([
            'co_eleitor' => $this->usuario['co_eleitor']
        ])->get()->isEmpty();

        if ($eleitorJaVotou) {
            throw new EValidacaoCampo('Só é possível votar apenas uma vez!');
        }

        return true;
    }
}
