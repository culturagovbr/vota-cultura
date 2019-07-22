<?php

namespace App\Modules\Conta\Services;

use App\Exceptions\ValidacaoCustomizadaException;
use App\Modules\Conta\Mail\Usuario\RecuperacaoSenha as RecuperacaoSenhaMail;
use App\Services\IService;
use App\Modules\Conta\Services\Usuario as UsuarioService;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use DB;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Mail;

class RecuperacaoSenha implements IService
{

    private $usuarioService;

    public function __construct(UsuarioService $usuarioService)
    {
        $this->usuarioService = $usuarioService;
    }

    public function recuperarSenha(array $dados)
    {
        try {
            $usuario = $this->usuarioService->getModel()->where(['no_cpf' => $dados['no_cpf'],
                    'dt_nascimento' => $dados['dt_nascimento'],
                    'ds_email' => $dados['ds_email'],
                    'st_ativo' => true]
            )->first();
            if (!$usuario) {
                throw new ValidacaoCustomizadaException(
                    'Usuario não encontrado',
                    Response::HTTP_NOT_ACCEPTABLE
                );
            }
            DB::beginTransaction();

            $horarioAtual = Carbon::now();
            $usuario->dt_ultima_atualizacao = $horarioAtual->toDateTimeString();
            $usuario->ds_codigo_alteracao =
                $this->usuarioService->gerarCodigoAlteracao(
                    $usuario->no_cpf,
                    $usuario->dt_nascimento,
                    $usuario->ds_email
                );
            $usuario->save();


            Mail::to($usuario->ds_email)->send(new RecuperacaoSenhaMail($usuario));

            DB::commit();
            return $usuario->toArray();

        } catch (\Exception $exception) {
            DB::rollBack();
            throw $exception;
        }

    }

    public function alterarSenha($codigo_alteracao, array $dados)
    {
        try {
            $usuario = $this->usuarioService->getModel()->where(['ds_codigo_alteracao' => $codigo_alteracao, 'st_ativo' => true])->first();
            if (!$usuario) {
                throw new ValidacaoCustomizadaException(
                    'Código inválido',
                    Response::HTTP_NOT_ACCEPTABLE
                );
            }
            DB::beginTransaction();
            $usuario->ds_codigo_alteracao = null;
            $usuario->setSenha($dados['ds_senha']);
            $usuario->save();
            DB::commit();

            return $usuario->toArray();

        } catch (\Exception $exception) {
            DB::rollBack();
            throw $exception;
        }

    }
}
