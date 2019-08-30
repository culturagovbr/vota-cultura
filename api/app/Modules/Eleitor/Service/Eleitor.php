<?php

namespace App\Modules\Eleitor\Service;

use App\Core\Service\AbstractService;
use App\Modules\Core\Exceptions\EParametrosInvalidos;
use App\Modules\Eleitor\Mail\Eleitor\CadastroComSucesso;
use App\Modules\Eleitor\Model\Eleitor as EleitorModel;
use App\Modules\Representacao\Model\Representante;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class Eleitor extends AbstractService
{
    public function __construct(EleitorModel $model)
    {
        parent::__construct($model);
    }

    public function cadastrar(array $dados): ?Model
    {
        try {
            DB::beginTransaction();
            $eleitor = $this->getModel()->where([
                'nu_cpf' => $dados['nu_cpf']
            ])->orWhere([
                'nu_rg' => $dados['nu_rg']
            ])->orWhere([
                'ds_email' => $dados['ds_email']
            ])->first();

            if ($eleitor) {
                throw new EParametrosInvalidos(
                    'Eleitor já cadastrado.',
                    Response::HTTP_NOT_ACCEPTABLE
                );
            }

            $representante = app()->make(Representante::class, [
                'ds_email' => $dados['ds_email'],
                'nu_cpf' => $dados['nu_cpf'],
            ])->first();

            $dados['co_usuario'] = $this->_obterCodigoUsuario($representante);
            $eleitor = parent::cadastrar($dados);

            Mail::to($eleitor->ds_email)
                ->send(
                new CadastroComSucesso($eleitor)
            );

            DB::commit();
            return $eleitor;
        } catch (EParametrosInvalidos $exception) {
            DB::rollBack();
            throw $exception;
        } catch (\Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    }

    private function _obterCodigoUsuario(Representante $representante) : int
    {
        $organizacao = $representante->organizacao;
        $conselho = $representante->conselho;

        if (!is_null($organizacao) && $organizacao->co_usuario) {
            return $organizacao->co_usuario;
        }

        if (!is_null($conselho) && $conselho->co_usuario) {
            return $conselho->co_usuario;
        }

        return NULL;
    }

    public function obterUm($identificador) : ?Model
    {
        $eleitor = parent::obterUm($identificador);
        if(!$eleitor) {
            throw new EParametrosInvalidos('Eleitor não encontrado');
        }

        if($eleitor->nu_cpf !== Auth::user()->nu_cpf) {
            throw new EParametrosInvalidos('O Eleitor precisa ser o mesmo que o usuário logado.');
        }

        return $eleitor;
    }
}
