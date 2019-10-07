<?php

namespace App\Modules\Organizacao\Service;

use App\Core\Service\AbstractService;
use App\Modules\Core\Exceptions\EParametrosInvalidos;
use App\Modules\Organizacao\Model\OrganizacaoHabilitacaoHistorico as HistoricoHabilitacao;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class OrganizacaoHabilitacaoHistorico extends AbstractService
{
    public function __construct(HistoricoHabilitacao $model)
    {
        parent::__construct($model);
    }

    public function cadastrar(Collection $dados): ?Model
    {
        try {
            DB::beginTransaction();

            if (empty($dados['co_organizacao_habilitacao'])) {
                throw new EParametrosInvalidos('Identificador da habilitação de organização não informado.');
            }

            $this->getModel()->where([
                'co_organizacao_habilitacao' => $dados['co_organizacao_habilitacao']
            ])->update(['st_ativo' => FALSE]);

            $dadosInclusao = $dados->only([
                'co_organizacao_habilitacao',
                'co_organizacao',
                'st_avaliacao',
                'ds_parecer',
                'nu_nova_pontuacao',
                'dh_avaliacao'
            ]);

            $organizacaoHabilitacao = $this->getModel()
                ->where($dadosInclusao->toArray())
                ->first();

            if ($organizacaoHabilitacao) {
                throw new EParametrosInvalidos(
                    'Revisão já cadastrada.',
                    Response::HTTP_NOT_ACCEPTABLE
                );
            }

            $novoHistorico = parent::cadastrar($dadosInclusao);

            DB::commit();
            return $novoHistorico;
        } catch (EParametrosInvalidos $queryException) {
            DB::rollBack();
            throw $queryException;
        }
    }
}
