<?php

namespace App\Modules\Conta\Service;

use App\Exceptions\ValidacaoCustomizadaException;
use App\Modules\Conta\Mail\Usuario\RecuperacaoSenha as RecuperacaoSenhaMail;
use App\Core\Service\IService;
use App\Modules\Conta\Service\Usuario as UsuarioService;
use App\Modules\Core\Exceptions\EParametrosInvalidos;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
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
            $usuario = $this->usuarioService->getModel()->where(
                [
                    'nu_cpf' => $dados['nu_cpf'],
                    'st_ativo' => true
                ]
            )->first();

            if (!$usuario) {
               throw new EParametrosInvalidos(
                   'Usuario não encontrado',
                   Response::HTTP_NOT_ACCEPTABLE
               );
            }

            if ($usuario->ds_email !== $dados['ds_email']) {
                throw new EParametrosInvalidos(
                    'O e-mail não corresponde ao e-mail cadastrado.',
                    Response::HTTP_NOT_ACCEPTABLE
                );
            }

            DB::beginTransaction();

            $horarioAtual = Carbon::now();
            $usuario->dh_ultima_atualizacao = $horarioAtual->toDateTimeString();

            $usuario->fill($dados);
            $usuario->gerarCodigoAtivacao();
            $usuario->save();

            Mail::to($usuario->ds_email)->send(
                app()->make(RecuperacaoSenhaMail::class, $usuario)
            );
            DB::commit();

            return $usuario->toArray();
        } catch (EParametrosInvalidos $exception) {
            DB::rollBack();
            throw $exception;
        } catch (\Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    }

    public function alterarSenha($ds_codigo_ativacao, array $dados)
    {
        try {
            $usuario = $this->usuarioService->getModel()->where([
                'ds_codigo_ativacao' => $ds_codigo_ativacao
            ])->first();
            if (!$usuario) {
                throw new EParametrosInvalidos(
                    'Código inválido ou já utilizado!',
                    Response::HTTP_NOT_ACCEPTABLE
                );
            }
            DB::beginTransaction();
            $usuario->ds_codigo_ativacao = null;
            $usuario->setSenha($dados['ds_senha']);
            $usuario->st_ativo = true;
            $horarioAtual = Carbon::now();
            $usuario->dh_ultima_atualizacao = $horarioAtual->toDateTimeString();
            $usuario->save();
            DB::commit();

            return $usuario->toArray();

        } catch (EParametrosInvalidos $exception) {
            DB::rollBack();
            throw $exception;
        } catch (\Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    }
}
