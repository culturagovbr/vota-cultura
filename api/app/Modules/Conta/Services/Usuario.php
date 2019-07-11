<?php

namespace App\Modules\Conta\Services;

use App\Exceptions\ValidacaoCustomizadaException;
use App\Modules\Conta\Model\Perfil;
use App\Services\IService;
use App\Modules\Conta\Model\Usuario as UsuarioModel;
use App\Modules\Conta\Model\UsuarioPerfil as UsuarioPerfilModel;
use Illuminate\Database\QueryException;
use DB;


class Usuario implements IService
{
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

                $usuarioPerfil = new UsuarioPerfilModel();
                $usuarioPerfil->co_usuario = $usuario->co_usuario;
                $usuarioPerfil->co_perfil = Perfil::CO_PERFIL_PADRAO;
                $usuarioPerfil->save();
            DB::commit();
            $usuario->perfil = $usuarioPerfil;
            return $usuario;

        } catch (QueryException $queryException) {
            DB::rollBack();
            throw $queryException;
        }

    }

    public function find($co_usuario)
    {
        return $this->model->find($co_usuario);
    }
}
