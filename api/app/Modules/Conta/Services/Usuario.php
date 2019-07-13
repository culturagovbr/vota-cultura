<?php

namespace App\Modules\Conta\Services;

use App\Exceptions\ValidacaoCustomizadaException;
use App\Modules\Conta\Model\Perfil;
use App\Services\IService;
use App\Modules\Conta\Model\Usuario as UsuarioModel;
use Illuminate\Database\QueryException;
use DB;

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

    public function cadastrar()
    {
        try {

            $usuario = $this->model->where(['no_cpf' => $this->model->no_cpf])->first();
            if ($usuario) {
                throw new ValidacaoCustomizadaException('Usuario já cadastradro.', 422);
            }

            DB::beginTransaction();
            $this->model->st_ativo = false;
            $this->model->ds_codigo_ativacao = $this->gerarCodigoAtivacao($this->model->no_email);

            // enviar e-mail

            $this->model->save();
            DB::commit();
        } catch (QueryException $queryException) {
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
}
