<?php

namespace App\Modules\Conselho\Service;

use App\Core\Service\AbstractService;
use App\Modules\Conselho\Model\ConselhoVotacao as ConselhoVotacaoModel;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;


class ConselhoVotacaoDesempate extends AbstractService
{

    public function __construct(ConselhoVotacaoModel $model)
    {
        parent::__construct($model);
    }

    public function obterTodos() : ?Collection
    {
      return collect(DB::select( DB::raw("
      WITH cte AS(
        SELECT
            tb_regiao.no_regiao,
            indicacao.no_indicado,
            indicacao.co_conselho_indicacao ,
            count(indicacao.co_conselho_indicacao) AS numero_votos,
            rank () over (
        ORDER BY
            count(indicacao.co_conselho_indicacao) desc ) AS ranking_empatado,
            dense_rank () over (
        ORDER BY
            count(indicacao.co_conselho_indicacao) desc ) AS ordenacao
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
            indicacao.co_conselho_indicacao, tb_regiao.no_regiao
        HAVING
            count(indicacao.co_conselho_indicacao) > :numero_min_votacoes)        
          
        SELECT * FROM cte where ranking_empatado < :numero_max_colocacoes;
      "), [
          'numero_max_colocacoes' =>  5,
          'numero_min_votacoes' =>  0,
      ]));
    }

}
