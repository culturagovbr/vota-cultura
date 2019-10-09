<?php

namespace App\Modules\Organizacao\Service;

use App\Core\Service\AbstractService;
use App\Modules\Core\Exceptions\EAcessoRestrito;
use App\Modules\Core\Exceptions\EParametrosInvalidos;
use App\Modules\Organizacao\Model\OrganizacaoHabilitacao as OrganizacaoHabilitacaoModel;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
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
            $dadosInclusao = $dados->only([
                'co_organizacao',
                'st_avaliacao',
                'ds_parecer',
                'nu_nova_pontuacao',
            ]);
            $dadosInclusao['dh_avaliacao'] = $carbon->toDateTimeString();
            $dadosUsuarioLogado = Auth::user()->dadosUsuarioAutenticado();
            $dadosInclusao['co_usuario_avaliador'] = $dadosUsuarioLogado['co_usuario'];

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

    public function revisarAvaliacao(Request $request, \App\Modules\Organizacao\Model\OrganizacaoHabilitacao $habilitacao): ?Model
    {
        try {
            DB::beginTransaction();
            if (!Auth::user()->souAdministrador()) {
                throw new EAcessoRestrito('Acesso restrito.');
            }

            $organizacaoHabilitacao = $this->obterUm($habilitacao->co_organizacao_habilitacao);
            if (empty($organizacaoHabilitacao)) {
                throw new EParametrosInvalidos('Habilitação da organização não localizada.');
            }

            $historicoService = app(OrganizacaoHabilitacaoHistorico::class);
            $historicoService->cadastrar(collect($organizacaoHabilitacao->toArray()));
            $organizacaoHabilitacao->fill($request->only([
                'st_avaliacao',
                'ds_parecer',
                'nu_nova_pontuacao',
                'st_revisao_final',
            ]));

            $carbon = Carbon::now();
            $organizacaoHabilitacao->dh_avaliacao = $carbon->toDateTimeString();
            $dadosUsuarioLogado = Auth::user()->dadosUsuarioAutenticado();
            $organizacaoHabilitacao->co_usuario_avaliador = $dadosUsuarioLogado['co_usuario'];
            $organizacaoHabilitacao->save();

            DB::commit();
            return $organizacaoHabilitacao;
        } catch (EParametrosInvalidos $queryException) {
            DB::rollBack();
            throw $queryException;
        }
    }
}
