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

    public function obterResultadoParcial(): ?Collection
    {
        return collect(DB::select(DB::raw("
      WITH cte AS(
        SELECT
            tb_regiao.no_regiao,
            indicacao.no_indicado,
            tb_regiao.co_regiao,
            indicacao.co_conselho_indicacao ,
            count(indicacao.co_conselho_indicacao) AS numero_votos,
            rank () over (
                PARTITION BY tb_regiao.no_regiao
                ORDER BY
                    count(indicacao.co_conselho_indicacao) desc ) AS ranking_empatado
        FROM
            tb_conselho_votacao
        INNER JOIN tb_conselho_indicacao indicacao ON
            indicacao.co_conselho_indicacao = tb_conselho_votacao.co_conselho_indicacao
        INNER JOIN tb_endereco ON
            tb_endereco.co_endereco = indicacao.co_endereco
        INNER JOIN tb_municipio ON
            tb_municipio.co_municipio = tb_endereco.co_municipio
        INNER JOIN tb_uf ON
            tb_uf.co_ibge = tb_municipio.co_uf
        INNER JOIN tb_regiao ON
            tb_regiao.co_regiao = tb_uf.co_regiao
        GROUP BY
            indicacao.co_conselho_indicacao, tb_regiao.no_regiao, tb_regiao.co_regiao
        HAVING
            count(indicacao.co_conselho_indicacao) >= :numero_min_votacoes)

        SELECT * FROM cte where ranking_empatado < :numero_max_colocacoes;
      "), [
            'numero_min_votacoes' => 0,
            'numero_max_colocacoes' => 5,
        ]));
    }

    public function registrarVoto(Collection $dados): ?Model
    {
        try {
            DB::beginTransaction();

            $this->verificarSeEleitorPodeVotar();
            $this->verificarNomeMaeReceita($dados['nomeMae']);
            $eleitorCriado = parent::cadastrar(collect([
                'co_conselho_indicacao' => (int)$dados['co_conselho_indicacao'],
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

        if ($dadosReceita['nmMae'] !== strtoupper(Str::ascii($nomeMae))) {
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
