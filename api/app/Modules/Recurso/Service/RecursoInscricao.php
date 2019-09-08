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
            $fase = $serviceFase->obterPorTipo($dados['tp_fase']);

            if ($fase->faseFinalizada()) {
                throw new EValidacaoCampo('O período de inscrição já foi encerrado.');
            }

            $dados['co_fase'] = $fase->co_fase;
            $carbon = Carbon::now();
            $dados['dh_cadastro'] = $carbon->toDateTimeString();
            $dadosInclusao = $dados->only([
                'co_fase',
                'ds_email',
                'nu_cnpj',
                'nu_cpf',
                'nu_telefone',
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

        $usuarioAutenticado = Auth::user()->dadosUsuarioAutenticado();
        if ($recursoInscricao->co_recurso_inscricao !== $usuarioAutenticado['co_recurso_inscricao']) {
            throw new EParametrosInvalidos('O Recurso não coincide com o do usuário logado.');
        }

        return $recursoInscricao;
    }
}
