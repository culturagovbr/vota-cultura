<?php

namespace App\Modules\Conselho\Service;

use App\Core\Service\AbstractService;
use App\Modules\Conselho\Model\ConselhoRanking;
use App\Modules\Conselho\Model\ConselhoVotacao as ConselhoVotacaoModel;
use App\Modules\Core\Exceptions\EParametrosInvalidos;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;


class ConselhoVotacaoDesempate extends AbstractService
{

    public function __construct(ConselhoVotacaoModel $model)
    {
        parent::__construct($model);
    }

    public function obterTodos(): ?Collection
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

    public function publicarResultadoDaVotacao(Collection $indicadosParaDesempate)
    {
        $desempate = (new ConselhoRanking())->get();

        if (!$desempate->isEmpty()) {
            throw new EParametrosInvalidos(
                'O resultado já foi publicado.',
                Response::HTTP_NOT_ACCEPTABLE
            );
        }

        $indicadosDesempatados = [];
        foreach ($indicadosParaDesempate as $indicadoPorRegiao) {
            foreach ($indicadoPorRegiao as $k => $indicado) {
                $indicadosDesempatados[] = [
                    'co_regiao' => $indicado['co_regiao'],
                    'co_conselho_indicacao' => $indicado['co_conselho_indicacao'],
                    'nu_votos' => $indicado['numero_votos'],
                    'nu_ranking' => $k + 1,
                ];
            }
        }
        return (new ConselhoRanking())->insert($indicadosDesempatados);
    }

    public function obterListaFinal(): ?Collection
    {
        $desempatados = DB::select(DB::raw("
           SELECT
               tb_regiao.no_regiao,
               indicacao.no_indicado,
               tb_conselho_ranking.nu_ranking,
               tb_conselho_ranking.nu_votos,
               tb_conselho_ranking.co_conselho_indicacao FROM tb_conselho_ranking
           INNER JOIN tb_conselho_indicacao indicacao ON
               indicacao.co_conselho_indicacao = tb_conselho_ranking.co_conselho_indicacao
           INNER JOIN tb_regiao ON
               tb_regiao.co_regiao = tb_conselho_ranking.co_regiao
           "));

        if (!$desempatados) {
            return collect([]);
        }

        $naoDesempatados = DB::select(DB::raw("
          WITH cte AS(
            SELECT
                tb_regiao.no_regiao,
                indicacao.no_indicado,
                tb_regiao.co_regiao,
                indicacao.co_conselho_indicacao ,
                count( indicacao.co_conselho_indicacao ) AS nu_votos,
                rank () over ( partition by tb_regiao.no_regiao
            ORDER BY
                count( indicacao.co_conselho_indicacao ) DESC ) AS nu_ranking
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
                indicacao.co_conselho_indicacao,
                tb_regiao.no_regiao,
                tb_regiao.co_regiao
            HAVING
                count( indicacao.co_conselho_indicacao ) >= 0 )
            SELECT * FROM cte WHERE co_conselho_indicacao NOT IN
                (select co_conselho_indicacao from tb_conselho_ranking) ORDER BY no_regiao, nu_ranking ASC;
          "));

        return collect(array_merge($desempatados, $naoDesempatados));
    }
}
