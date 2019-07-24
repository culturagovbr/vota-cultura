<?php

namespace App\Modules\Conselho\Services;

use App\Exceptions\ValidacaoCustomizadaException;
use App\Modules\Conselho\Mail\Conselho\CadastroComSucesso;
use App\Modules\Conselho\Model\Perfil;
use App\Services\AbstractService;
use App\Modules\Conselho\Model\Conselho as ConselhoModel;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use DB;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class Conselho extends AbstractService
{
    public function __construct(ConselhoModel $model)
    {
        parent::__construct($model);
    }

    public function ativarConselhoPorCodigoAtivacao($codigo_ativacao)
    {
        try {
            $conselho = $this->getModel()->where([
                'ds_codigo_ativacao' => $codigo_ativacao, 'st_ativo' => false])->first();
            if (!$conselho) {
                throw new ValidacaoCustomizadaException('Conselho não encontrado', 422);
            }
            DB::beginTransaction();
            $conselho->st_ativo = true;
            $conselho->save();
            $conselho->perfis()->attach(Perfil::CO_PERFIL_PADRAO);
            DB::commit();
            $conselho->perfis = $conselho->perfis()->get();

            return $conselho;

        } catch (QueryException $queryException) {
            DB::rollBack();
            throw $queryException;
        }

    }

    public function cadastrar(array $dados)
    {
        try {
            $conselho = $this->getModel()->where([
                'ds_email' => $dados['ds_email']
            ])->orWhere([
                'no_orgao_gestor' => $dados['no_orgao_gestor']
            ])->orWhere([
                'nu_cnpj' => $dados['nu_cnpj']
            ])->first();

            if ($conselho) {
                throw new ValidacaoCustomizadaException(
                    'Conselho já cadastrado.',
                    Response::HTTP_NOT_ACCEPTABLE
                );
            }

            DB::beginTransaction();
            $conselho = $this->getModel();
            $conselho->fill($dados);
            $conselho->co_endereco = $dados['co_endereco'];
            $conselho->co_representante = $dados['co_representante'];
            $conselho->co_usuario = $dados['co_usuario'];
            $conselho->ds_sitio_eletronico = $dados['ds_sitio_eletronico'];

            $conselho->save();

            Mail::to($conselho->ds_email)->send(
                new CadastroComSucesso($conselho)
            );
            DB::commit();
            return $conselho;
        } catch (\Exception $queryException) {
            DB::rollBack();
            throw $queryException;
        }
    }

    public function obterUm($co_conselho)
    {
        return $this->getModel()->find($co_conselho);
    }

    public function obterTodos()
    {
        return $this->getModel()->get();
    }

    public function atualizar(Request $request, int $co_conselho)
    {
        try {
            $conselho = $this->getModel()->find($co_conselho);
            if (!$conselho) {
                throw new ValidacaoCustomizadaException(
                    'Usuário não encontrado.',
                    Response::HTTP_NOT_ACCEPTABLE
                );
            }

            if ($request->user()->co_conselho !== $conselho->co_conselho) {
                return response()->json(
                    ['error' => 'Operação não permitida.'],
                    Response::HTTP_UNAUTHORIZED
                );
            }
            DB::beginTransaction();

            $horarioAtual = Carbon::now();
            $conselho->dt_ultima_atualizacao = $horarioAtual->toDateTimeString();
            $conselho->setSenha($request->post('ds_senha'));
            $conselho->dt_nascimento = $request->post('dt_nascimento');
            $conselho->no_nome = $request->post('no_nome');
            $conselho->save();

            DB::commit();
            return $conselho->toArray();
        } catch (\Exception $queryException) {
            DB::rollBack();
            throw $queryException;
        }
    }

    public function remover(Request $request, ConselhoModel $conselho)
    {
        try {
            if ($request->user()->co_conselho !== $conselho->co_conselho) {
                return response()->json(
                    ['error' => 'Operação não permitida.'],
                    Response::HTTP_UNAUTHORIZED
                );
            }
            DB::beginTransaction();

            $horarioAtual = Carbon::now();
            $conselho->dt_ultima_atualizacao = $horarioAtual->toDateTimeString();
            $conselho->st_ativo = false;
            $conselho->save();

            ## $conselho->delete();

            DB::commit();
        } catch (\Exception $queryException) {
            DB::rollBack();
            throw $queryException;
        }

    }

    public function alterarSenha(Request $request, int $co_conselho)
    {
        try {
            DB::beginTransaction();
            $dados = $request->all();
            if (!$dados || !isset($dados['ds_senha_atual'])) {
                throw new ValidacaoCustomizadaException(
                    'Senha não informada.',
                    Response::HTTP_NOT_ACCEPTABLE
                );
            }
            $conselho = $this->getModel()->find($co_conselho);

            if (!$conselho || !$conselho->validarSenha($dados['ds_senha_atual'])) {
                throw new ValidacaoCustomizadaException(
                    'Dados inválidos.',
                    Response::HTTP_NOT_ACCEPTABLE
                );
            }

            $conselho->setSenha($dados['ds_senha']);
            $conselho->save();
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    }
}
