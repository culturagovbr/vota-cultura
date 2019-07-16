<?php

namespace App\Modules\Conta\Services;

use App\Exceptions\ValidacaoCustomizadaException;
use App\Modules\Conta\Model\Perfil;
use App\Services\IService;
use App\Modules\Conta\Model\Usuario as UsuarioModel;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use DB;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

class Usuario implements IService
{
    /**
     * @var UsuarioModel $model
     */
    private $model;

    public function __construct(UsuarioModel $model)
    {
        $this->model = $model;
    }

    public function ativarUsuarioPorCodigoAtivacao($codigo_ativacao)
    {
        try {
            $usuario = $this->model->where(['ds_codigo_ativacao' => $codigo_ativacao, 'st_ativo' => false])->first();
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

    public function cadastrar(array $dados)
    {
        try {

            $usuario = $this->model->where([
                'no_cpf' => $dados['no_cpf']
            ])->first();
            if ($usuario) {
                throw new ValidacaoCustomizadaException(
                    'Usuario já cadastrado.',
                    Response::HTTP_NOT_ACCEPTABLE
                );
            }
            DB::beginTransaction();
            $this->model->no_cpf = $dados['no_cpf'];
            $this->model->no_email = $dados['no_email'];
            $this->model->no_nome = $dados['no_nome'];
            $this->model->dt_nascimento = $dados['dt_nascimento'];
            $this->model->ds_codigo_ativacao = $this->gerarCodigoAtivacao($dados['no_email']);
            $horarioAtual = Carbon::now();
            $this->model->dt_cadastro = $horarioAtual->toDateTimeString();
            $this->model->dt_ultima_atualizacao = $horarioAtual->toDateTimeString();
            $this->model->st_ativo = false;
            $this->model->ds_senha = password_hash($dados['dt_nascimento'], PASSWORD_DEFAULT);

            // enviar e-mail

            $this->model->save();
            DB::commit();
            return $this->model;
        } catch (\Exception $queryException) {
            DB::rollBack();
            throw $queryException;
        }
    }

    public function obterUm($co_usuario)
    {
        return $this->model->find($co_usuario);
    }

    public function obterTodos()
    {
        return $this->model->get();
    }

    public function atualizar(Request $request, UsuarioModel $usuario)
    {
        if ($request->user()->co_usuario !== $usuario->co_usuario) {
            return response()->json(
                ['error' => 'Operação não permitida.'],
                Response::HTTP_UNAUTHORIZED
            );
        }

        $usuario->update($request->only([
            'ds_senha',
            'dt_nascimento',
            'no_nome',
        ]));

        return $usuario->toArray();
    }
}
