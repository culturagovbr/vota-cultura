<?php

namespace App\Modules\Recurso\Service;

use App\Core\Service\AbstractService;
use App\Modules\Core\Exceptions\EParametrosInvalidos;
use App\Modules\Core\Exceptions\EValidacaoCampo;
use App\Modules\Fase\Service\Fase as FaseService;
use App\Modules\Recurso\Mail\RecursoInscricao\CadastroComSucesso;
use App\Modules\Recurso\Model\RecursoInscricao as RecursoInscricaoModel;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class RecursoInscricao extends AbstractService
{
    public function __construct(RecursoInscricaoModel $model)
    {
        parent::__construct($model);
    }

    public function cadastrar(Collection $dados): ?Model
    {
        try {
            DB::beginTransaction();

            $serviceFase = app()->make(FaseService::class);
            $fase = $serviceFase->getModel()->find($dados['co_fase']);

            if (empty($fase) || $fase->faseFinalizada()) {
                throw new EValidacaoCampo('O período de inscrição já foi encerrado.');
            }

            $carbon = Carbon::now();
            $dados['dh_cadastro'] = $carbon->toDateTimeString();
            $dadosInclusao = $dados->only([
                'co_fase',
                'ds_email',
                'nu_cnpj',
                'nu_cpf',
                'nu_telefone',
                'dh_cadastro',
                'ds_recurso',
            ])->toArray();

            $recursoInscricao = $this->getModel()->where(
                $dadosInclusao
            )->first();

            if ($recursoInscricao) {
                throw new EParametrosInvalidos(
                    'Recurso de Inscrição já cadastrada.',
                    Response::HTTP_NOT_ACCEPTABLE
                );
            }

            $novoRecursoInscricao = parent::cadastrar($dados);

            Mail::to($novoRecursoInscricao->ds_email)
                ->bcc(env('EMAIL_ACOMPANHAMENTO'))
                ->send(
                    app()->make(
                        CadastroComSucesso::class,
                        $novoRecursoInscricao->toArray()
                    )
                );

            DB::commit();
            return $novoRecursoInscricao;
        } catch (EParametrosInvalidos $queryException) {
            DB::rollBack();
            throw $queryException;
        }
    }

    public function obterUm($identificador): ?Model
    {
        $recursoInscricao = parent::obterUm($identificador);
        if (!$recursoInscricao) {
            throw new EParametrosInvalidos('Organização não encontrado');
        }

        if (!Auth::user()->souAdministrador()) {
            throw new EParametrosInvalidos('Funcionalidade indisponível para seu perfil.');
        }

        return $recursoInscricao;
    }

    public function atualizar(Request $request, int $identificador) : ?Model
    {
        $dados = collect(
            $request->only([
                'ds_parecer',
                'st_parecer',
                'co_usuario_parecer',
            ]));

        try {
            $recursoInscricao = $this->getModel()->where(
                $dados->only([
                    'co_recursoInscricao'
                ])->toArray()
            )->first();

            if (empty($recursoInscricao)) {
                throw new EParametrosInvalidos(
                    'Recurso não encontrado.',
                    Response::HTTP_NOT_ACCEPTABLE
                );
            }

            DB::beginTransaction();
            $recursoInscricao->fill($dados->toArray());
            $horarioAtual = Carbon::now();

            $recursoInscricao->dh_parecer = $horarioAtual->toDateTimeString();
            $recursoInscricao->save();

            DB::commit();
            return $recursoInscricao;
        } catch (EParametrosInvalidos $queryException) {
            DB::rollBack();
            throw $queryException;
        }
    }
}
