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
         select tb_regiao.no_regiao, tb_conselho_indicacao.no_indicado,
            tb_conselho_indicacao.co_conselho_indicacao,
            count(tb_conselho_votacao.*) AS nu_votos,
            rank () over (
                partition by tb_regiao.no_regiao
                order by
                count( tb_conselho_votacao.* ) desc ) as ranking_empatado
        from
            tb_conselho_indicacao
        left join tb_conselho_votacao on
            tb_conselho_votacao.co_conselho_indicacao = tb_conselho_indicacao.co_conselho_indicacao
        inner join tb_endereco on
            tb_endereco.co_endereco = tb_conselho_indicacao.co_endereco
        inner join tb_municipio on
            tb_municipio.co_municipio = tb_endereco.co_municipio
        inner join tb_uf on
            tb_uf.co_ibge = tb_municipio.co_uf
        inner join tb_regiao on
            tb_regiao.co_regiao = tb_uf.co_regiao
        inner join tb_conselho_indicacao_habilitacao on
        	tb_conselho_indicacao_habilitacao.co_indicado = tb_conselho_indicacao.co_conselho_indicacao
        where tb_conselho_indicacao_habilitacao.st_avaliacao = '1'
        group by
            tb_conselho_indicacao.co_conselho_indicacao, tb_regiao.co_regiao, tb_conselho_indicacao.no_indicado, tb_regiao.no_regiao
        order by tb_regiao.no_regiao, ranking_empatado
        ")));

    }

    public function registrarVoto(Collection $dados): ?Model
    {
        try {
            DB::beginTransaction();

            $this->verificarSeEleitorPodeVotar();
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
