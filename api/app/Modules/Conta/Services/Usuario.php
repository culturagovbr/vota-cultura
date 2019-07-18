<?php

namespace App\Modules\Conta\Services;

use App\Exceptions\ValidacaoCustomizadaException;
use App\Modules\Conta\Mail\Usuario\CadastroComSucesso;
use App\Modules\Conta\Model\Perfil;
use App\Services\AbstractService;
use App\Modules\Conta\Model\Usuario as UsuarioModel;
use Carbon\Carbon;
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

    public function cadastrar(array $dados)
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
            $this->getModel()->no_cpf = $dados['no_cpf'];
            $this->getModel()->no_email = $dados['no_email'];
            $this->getModel()->no_nome = $dados['no_nome'];
            $this->getModel()->dt_nascimento = $dados['dt_nascimento'];
            $this->getModel()->ds_codigo_ativacao = $this->gerarCodigoAtivacao(
                $dados['no_email']
            );
            $horarioAtual = Carbon::now();
            $this->getModel()->dt_cadastro = $horarioAtual->toDateTimeString();
            $this->getModel()->dt_ultima_atualizacao = $horarioAtual->toDateTimeString();
            $this->getModel()->st_ativo = false;
            $this->getModel()->setSenha($dados['ds_senha']);

            $this->getModel()->save();

            Mail::to($this->getModel()->no_email)->send(new CadastroComSucesso($this->getModel()));
            DB::commit();
            return $this->getModel();
        } catch (\Exception $queryException) {
            DB::rollBack();
            throw $queryException;
        }
    }

    public function obterUm($co_usuario)
    {
        return $this->getModel()->find($co_usuario);
    }

    public function obterTodos()
    {
        return $this->getModel()->get();
    }

    public function atualizar(Request $request, UsuarioModel $usuario)
    {
        try {
            if ($request->user()->co_usuario !== $usuario->co_usuario) {
                return response()->json(
                    ['error' => 'Operação não permitida.'],
                    Response::HTTP_UNAUTHORIZED
                );
            }
            DB::beginTransaction();

            $horarioAtual = Carbon::now();
            $usuario->dt_ultima_atualizacao = $horarioAtual->toDateTimeString();
            $usuario->update($request->only([
                'ds_senha',
                'dt_nascimento',
                'no_nome',
            ]));

            // enviar e-mail

            DB::commit();
            return $usuario->toArray();
        } catch (\Exception $queryException) {
            DB::rollBack();
            throw $queryException;
        }
    }

    public function remover(Request $request, UsuarioModel $usuario)
    {
        try {
            if ($request->user()->co_usuario !== $usuario->co_usuario) {
                return response()->json(
                    ['error' => 'Operação não permitida.'],
                    Response::HTTP_UNAUTHORIZED
                );
            }
            DB::beginTransaction();

            $horarioAtual = Carbon::now();
            $usuario->dt_ultima_atualizacao = $horarioAtual->toDateTimeString();
            $usuario->update(['st_ativo' => false]);

            ## $usuario->delete();

            // enviar e-mail

            DB::commit();
        } catch (\Exception $queryException) {
            DB::rollBack();
            throw $queryException;
        }

    }
}
