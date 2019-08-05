<?php

namespace App\Modules\Conta\Service;

use App\Exceptions\ValidacaoCustomizadaException;
use App\Modules\Conta\Mail\Usuario\CadastroComSucesso;
use App\Modules\Conta\Model\Perfil;
use App\Core\Service\AbstractService;
use App\Modules\Conta\Model\Usuario as UsuarioModel;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use DB;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class Usuario extends AbstractService
{
    public function __construct(UsuarioModel $model)
    {
        parent::__construct($model);
    }

    public function ativarUsuarioPorCodigoAtivacao($codigo_ativacao)
    {
        try {
            $usuario = $this->getModel()->where(['ds_codigo_ativacao' => $codigo_ativacao, 'st_ativo' => false])->first();
            if (!$usuario) {
                throw new ValidacaoCustomizadaException('Usuario não encontrado', 422);
            }
            DB::beginTransaction();
            $usuario->st_ativo = true;
            $usuario->save();
            $usuario->perfis()->attach(Perfil::CO_PERFIL_PADRAO);
            DB::commit();
            $usuario->perfis = $usuario->perfis()->get();

            return $usuario;

        } catch (QueryException $queryException) {
            DB::rollBack();
            throw $queryException;
        }

    }

    private function gerarCodigoAtivacao($email)
    {
        return sha1(mt_rand(1, 999) . time() . $email);
    }

    public function gerarCodigoAlteracao($cpf, $dataNascimento, $email)
    {
        return sha1(mt_rand(1, 999) . time() . $cpf . $dataNascimento . $email);
    }

    public function cadastrar(array $dados) : ?Model
    {
        try {
            $usuario = $this->getModel()->where([
                'no_cpf' => $dados['no_cpf']
            ])->first();

            if ($usuario) {
                throw new ValidacaoCustomizadaException(
                    'Usuario já cadastrado.',
                    Response::HTTP_NOT_ACCEPTABLE
                );
            }

            DB::beginTransaction();
            $usuario = $this->getModel();
            $usuario->no_cpf = $dados['no_cpf'];
            $usuario->ds_email = $dados['ds_email'];
            $usuario->no_nome = $dados['no_nome'];
            $usuario->dt_nascimento = $dados['dt_nascimento'];
            $usuario->ds_codigo_ativacao = $this->gerarCodigoAtivacao(
                $dados['ds_email']
            );
            $horarioAtual = Carbon::now();
            $usuario->dh_cadastro = $horarioAtual->toDateTimeString();
            $usuario->dh_ultima_atualizacao = $horarioAtual->toDateTimeString();
            $usuario->st_ativo = false;
            $usuario->setSenha($dados['ds_senha']);

            $usuario->save();

            Mail::to($usuario->ds_email)->send(
                new CadastroComSucesso($usuario)
            );
            DB::commit();
            return $usuario;
        } catch (\Exception $queryException) {
            DB::rollBack();
            throw $queryException;
        }
    }

    public function atualizar(Request $request, int $co_usuario) : ?Model
    {
        try {
            $usuario = $this->getModel()->find($co_usuario);
            if (!$usuario) {
                throw new ValidacaoCustomizadaException(
                    'Usuário não encontrado.',
                    Response::HTTP_NOT_ACCEPTABLE
                );
            }

            if ($request->user()->co_usuario !== $usuario->co_usuario) {
                return response()->json(
                    ['error' => 'Operação não permitida.'],
                    Response::HTTP_UNAUTHORIZED
                );
            }
            DB::beginTransaction();

            $horarioAtual = Carbon::now();
            $usuario->dt_ultima_atualizacao = $horarioAtual->toDateTimeString();
            $usuario->setSenha($request->post('ds_senha'));
            $usuario->dt_nascimento = $request->post('dt_nascimento');
            $usuario->no_nome = $request->post('no_nome');
            $usuario->save();

            DB::commit();
            return $usuario->toArray();
        } catch (\Exception $queryException) {
            DB::rollBack();
            throw $queryException;
        }
    }

    public function remover(Request $request, int $identificador)
    {
        try {
            if ($request->user()->co_usuario !== $identificador) {
                return response()->json(
                    ['error' => 'Operação não permitida.'],
                    Response::HTTP_UNAUTHORIZED
                );
            }
            DB::beginTransaction();

            $usuario = $this->getModel()->find($identificador);
            $horarioAtual = Carbon::now();
            $usuario->dt_ultima_atualizacao = $horarioAtual->toDateTimeString();
            $usuario->st_ativo = false;
            $usuario->save();

            ## $usuario->delete();

            DB::commit();
        } catch (\Exception $queryException) {
            DB::rollBack();
            throw $queryException;
        }

    }

    public function alterarSenha(Request $request, int $co_usuario)
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
            $usuario = $this->getModel()->find($co_usuario);

            if (!$usuario || !$usuario->validarSenha($dados['ds_senha_atual'])) {
                throw new ValidacaoCustomizadaException(
                    'Dados inválidos.',
                    Response::HTTP_NOT_ACCEPTABLE
                );
            }

            $usuario->setSenha($dados['ds_senha']);
            $usuario->save();
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    }
}
