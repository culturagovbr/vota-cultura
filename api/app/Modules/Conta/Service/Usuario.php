<?php

namespace App\Modules\Conta\Service;

use App\Modules\Conselho\Model\Conselho as ConselhoModel;
use App\Modules\Organizacao\Model\Organizacao as OrganizacaoModel;
use App\Modules\Conta\Mail\Usuario\CadastroComSucesso;
use App\Modules\Conta\Model\Perfil as PerfilModel;
use App\Core\Service\AbstractService;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Modules\Eleitor\Model\Eleitor as EleitorModel;
use App\Modules\Conta\Model\Usuario as UsuarioModel;


class Usuario extends AbstractService
{
    public function __construct(UsuarioModel $model)
    {
        parent::__construct($model);
    }

    public function gerarPrimeiroAcesso(Request $request)
    {
        try {
            DB::beginTransaction();

            switch ($request->tp_inscricao) {
                case 'eleitor':
                    $eleitorModel = app()->makeWith(EleitorModel::class, $request->post());
                    $model = $eleitorModel->whereNull('co_usuario')->firstOrFail();
                    $dadosUsuario = $model->toArray();
                    $dadosUsuario['co_perfil'] = PerfilModel::CODIGO_ELEITOR;
                    break;
                case 'conselho':
                    $conselhoModel = app()->makeWith(ConselhoModel::class, $request->post());
                    $model = $conselhoModel->whereNull('co_usuario')->firstOrFail();
                    $representante = $model->representante;
                    $dadosUsuario = $representante->toArray();
                    $dadosUsuario['co_perfil'] = PerfilModel::CODIGO_CONSELHO;
                    break;
                case 'organizacao':
                    $organizacaoModel = app()->makeWith(OrganizacaoModel::class, $request->post());
                    $model = $organizacaoModel->whereNull('co_usuario')->firstOrFail()->representante;
                    $representante = $model->representante;
                    $dadosUsuario = $representante->toArray();
                    $dadosUsuario['co_perfil'] = PerfilModel::CODIGO_ORGANIZACAO;
                    break;
                default:
                    throw new \Exception("Tipo de inscrição desconhecido.");
                    break;
            }

            $usuarioModel = $this->cadastrar($dadosUsuario);
            $model->co_usuario = $usuarioModel->co_usuario;
            $model->save();

            DB::commit();
            return $usuarioModel;
        } catch (\Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    }

    public function ativarUsuarioPorCodigoAtivacao($codigo_ativacao)
    {
        try {

            $usuario = $this->getModel()->where([
                'ds_codigo_ativacao' => $codigo_ativacao,
                'st_ativo' => false
            ])->first();
            if (!$usuario) {
                throw new \Exception('Usuario não encontrado', 422);
            }

            DB::beginTransaction();
            $usuario->st_ativo = true;
            $usuario->ds_codigo_ativacao = null;
            $usuario->save();
            DB::commit();

            return $usuario;

        } catch (\Exception $exception) {
            DB::rollBack();
            throw $exception;
        }

    }

    public function cadastrar(array $dados): ?Model
    {
        try {
            $usuario = $this->getModel()->where([
                'nu_cpf' => $dados['nu_cpf']
            ])->first();

            if ($usuario) {
                throw new \Exception(
                    'Usuario já cadastrado.',
                    Response::HTTP_NOT_ACCEPTABLE
                );
            }

            $dados['ds_senha'] = substr(sha1(time()), 0, 8);

            DB::beginTransaction();
            $usuario = $this->getModel();
            unset($dados['dh_cadastro']);
            $usuario->fill($dados);
            $usuario->gerarCodigoAtivacao();
            $horarioAtual = Carbon::now();
            $usuario->dh_cadastro = $horarioAtual->toDateTimeString();
            $usuario->dh_ultima_atualizacao = $horarioAtual->toDateTimeString();
            $usuario->st_ativo = false;
            $usuario->setSenha($dados['ds_senha']);
            $usuario->save();

            $usuario->ds_senha = $dados['ds_senha'];

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

    public function alterarSenha(Request $request, int $co_usuario)
    {
        try {
            DB::beginTransaction();
            $dados = $request->all();
            if (!$dados || !isset($dados['ds_senha_atual'])) {
                throw new \Exception(
                    'Senha não informada.',
                    Response::HTTP_NOT_ACCEPTABLE
                );
            }
            $usuario = $this->getModel()->find($co_usuario);

            if (!$usuario || !$usuario->validarSenha($dados['ds_senha_atual']) ) {
                throw new \Exception(
                    'Dados inválidos.',
                    Response::HTTP_NOT_ACCEPTABLE
                );
            }

            if($usuario->validarSenha($dados['ds_senha'])) {
                throw new \Exception(
                    'A nova senha é igual a atual.',
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

//
//    public function atualizar(Request $request, int $co_usuario) : ?Model
//    {
//        try {
//            $usuario = $this->getModel()->find($co_usuario);
//            if (!$usuario) {
//                throw new ValidacaoCustomizadaException(
//                    'Usuário não encontrado.',
//                    Response::HTTP_NOT_ACCEPTABLE
//                );
//            }
//
//            if ($request->user()->co_usuario !== $usuario->co_usuario) {
//                return response()->json(
//                    ['error' => 'Operação não permitida.'],
//                    Response::HTTP_UNAUTHORIZED
//                );
//            }
//            DB::beginTransaction();
//
//            $horarioAtual = Carbon::now();
//            $usuario->dt_ultima_atualizacao = $horarioAtual->toDateTimeString();
//            $usuario->setSenha($request->post('ds_senha'));
//            $usuario->dt_nascimento = $request->post('dt_nascimento');
//            $usuario->no_nome = $request->post('no_nome');
//            $usuario->save();
//
//            DB::commit();
//            return $usuario->toArray();
//        } catch (\Exception $queryException) {
//            DB::rollBack();
//            throw $queryException;
//        }
//    }
//
//    public function remover(Request $request, int $identificador)
//    {
//        try {
//            if ($request->user()->co_usuario !== $identificador) {
//                return response()->json(
//                    ['error' => 'Operação não permitida.'],
//                    Response::HTTP_UNAUTHORIZED
//                );
//            }
//            DB::beginTransaction();
//
//            $usuario = $this->getModel()->find($identificador);
//            $horarioAtual = Carbon::now();
//            $usuario->dt_ultima_atualizacao = $horarioAtual->toDateTimeString();
//            $usuario->st_ativo = false;
//            $usuario->save();
//
//            ## $usuario->delete();
//
//            DB::commit();
//        } catch (\Exception $queryException) {
//            DB::rollBack();
//            throw $queryException;
//        }
//
//    }
//

}
