<?php

namespace App\Modules\Organizacao\Service;

use App\Core\Service\AbstractService;
use App\Modules\Core\Exceptions\EParametrosInvalidos;
use App\Modules\Organizacao\Model\OrganizacaoHabilitacao as OrganizacaoHabilitacaoModel;
use App\Modules\Representacao\Model\RepresentanteArquivoAvaliacao;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrganizacaoHabilitacao extends AbstractService
{
    public function __construct(OrganizacaoHabilitacaoModel $model)
    {
        parent::__construct($model);
    }

    public function cadastrar(Collection $dados): ?Model
    {
        try {
            DB::beginTransaction();
            $carbon = Carbon::now();
            $dadosInclusao = $dados->only(
                [
                    'co_organizacao',
                    'st_avaliacao',
                    'ds_parecer',
                    'nu_nova_pontuacao',
                ]
            );
            $dadosInclusao['dh_avaliacao'] = $carbon->toDateTimeString();

            $organizacaoHabilitacao = $this->getModel()
                ->where($dadosInclusao->toArray())
                ->first();

            if ($organizacaoHabilitacao) {
                throw new EParametrosInvalidos(
                    'Avaliação já realizada.',
                    Response::HTTP_NOT_ACCEPTABLE
                );
            }

            $novoOrganizacaoHabilitacao = parent::cadastrar($dadosInclusao);

            DB::commit();
            return $novoOrganizacaoHabilitacao;
        } catch (EParametrosInvalidos $queryException) {
            DB::rollBack();
            throw $queryException;
        }
    }

    public function revisarAvaliacao()
    {
//            $arquivosHabilitacacao = [];
//            if (!empty($dados['arquivosAvaliacao']) && Auth::user()->souAdministrador() ) {
//                $dadosUsuarioLogado = Auth::user()->dadosUsuarioAutenticado();
//                foreach (array_values($dados['arquivosAvaliacao']) as $indice => $arquivoAvaliacao) {
//                    if(empty($arquivoAvaliacao['co_representante_arquivo'])) {
//                        continue;
//                    }
//                    $colecao = collect($arquivoAvaliacao);
//                    $colecao['co_organizacao_habilitacao'] = $novoOrganizacaoHabilitacao->co_organizacao_habilitacao;
//                    $colecao['co_usuario_avaliador'] = $dadosUsuarioLogado['co_usuario'];
//                    $colecao['dh_avaliacao'] = $carbon->toDateTimeString();
//                    $colecao['st_em_conformidade'] = RepresentanteArquivoAvaliacao::SITUACAO_CONFORMIDADE_NAO_CONFORME;
//                    if ((int)$dadosInclusao['st_avaliacao'] === (int)OrganizacaoHabilitacaoModel::SITUACAO_AVALIACAO_HABILITADA_CLASSIFICADA) {
//                        $colecao['st_em_conformidade'] = RepresentanteArquivoAvaliacao::SITUACAO_CONFORMIDADE_CONFORME;
//                    }
//                    $arquivosHabilitacacao[$indice] = $colecao->only(
//                        [
//                            'co_representante_arquivo',
//                            'st_em_conformidade',
//                            'co_usuario_avaliador',
//                            'dh_avaliacao',
//                            'co_organizacao_habilitacao',
//                        ]
//                    )->toArray();
//                }
//
//                $novoOrganizacaoHabilitacao->representanteArquivoAvaliacao()->insert($arquivosHabilitacacao);
//            }
    }
}
