<?php

namespace App\Modules\Organizacao\Service;

use App\Core\Service\AbstractService;
use App\Modules\Core\Exceptions\EParametrosInvalidos;
use App\Modules\Organizacao\Model\OrganizacaoHabilitacao as OrganizacaoHabilitacaoModel;
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
                ]
            )->toArray();
            $dadosInclusao['dh_avaliacao'] = $carbon->toDateTimeString();

            $organizacaoHabilitacao = $this->getModel()
                ->where($dadosInclusao)
                ->first();

            if ($organizacaoHabilitacao) {
                throw new EParametrosInvalidos(
                    'Avaliação já realizada.',
                    Response::HTTP_NOT_ACCEPTABLE
                );
            }

            $novoOrganizacaoHabilitacao = parent::cadastrar($dados);
            $arquivosHabilitacacao = [];
            if (!empty($dados['arquivosAvaliacao'])) {
                $dadosUsuarioLogado = Auth::user()->dadosUsuarioAutenticado();
                $indice = 0;
                foreach (array_values($dados['arquivosAvaliacao']) as $arquivoAvaliacao) {
                    $colecao = collect($arquivoAvaliacao);
                    $colecao['co_organizacao_habilitacao'] = $novoOrganizacaoHabilitacao->co_organizacao_habilitacao;
                    $colecao['co_usuario_avaliador'] = $dadosUsuarioLogado['co_usuario'];
                    $colecao['dh_avaliacao'] = $carbon->toDateTimeString();
                    $arquivosHabilitacacao[$indice] = $colecao->only(
                        [
                            'co_representante_arquivo',
                            'st_em_conformidade',
                            'ds_observacao',
                            'co_usuario_avaliador',
                            'dh_avaliacao',
                            'co_organizacao_habilitacao',
                        ]
                    )->toArray();
                    $indice++;
                }

                $novoOrganizacaoHabilitacao->representanteArquivoAvaliacao()->insert($arquivosHabilitacacao);
            }

            DB::commit();
            return $novoOrganizacaoHabilitacao;
        } catch (EParametrosInvalidos $queryException) {
            DB::rollBack();
            throw $queryException;
        }
    }
}
