<?php

namespace App\Modules\Eleitor\Service;

use App\Core\Service\AbstractService;
use App\Modules\Conta\Model\Usuario;
use App\Modules\Core\Exceptions\EParametrosInvalidos;
use App\Modules\Core\Exceptions\EValidacaoCampo;
use App\Modules\Eleitor\Mail\Eleitor\CadastroComSucesso;
use App\Modules\Eleitor\Model\Eleitor as EleitorModel;
use App\Modules\Fase\Model\Fase as FaseModel;
use App\Modules\Fase\Service\Fase as FaseService;
use App\Modules\Representacao\Model\Representante;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class Eleitor extends AbstractService
{
    public function __construct(EleitorModel $model)
    {
        parent::__construct($model);
    }

    public function cadastrar(Collection $dados): ?Model
    {
        try {
            DB::beginTransaction();

            $serviceFase = app()->make(FaseService::class);
            $fase = $serviceFase->obterPorTipo(FaseModel::ABERTURA_INSCRICOES_ELEITOR);

            if ($fase->faseFinalizada()) {
                throw new EValidacaoCampo('O período de inscrição já foi encerrado.');
            }

            $eleitor = $this->getModel()->where(
                $dados->only([
                    'nu_cpf',
                    'nu_rg',
                    'ds_email',
                ])->toArray()
            )->first();

            if ($eleitor) {
                throw new EParametrosInvalidos(
                    'Eleitor já cadastrado.',
                    Response::HTTP_NOT_ACCEPTABLE
                );
            }

            $usuario = app()->make(Usuario::class)->where([
                'nu_cpf' => $dados['nu_cpf'],
            ])->first();

            $dados['co_usuario'] = !empty($usuario) ? $usuario->co_usuario : null;

            $eleitorCriado = parent::cadastrar($dados);

            Mail::to($eleitorCriado->ds_email)->send(
                app()->make(CadastroComSucesso::class, $eleitorCriado->toArray())
            );

            DB::commit();
            return $eleitorCriado;
        } catch (EParametrosInvalidos $exception) {
            DB::rollBack();
            throw $exception;
        } catch (\Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    }

    private function _obterCodigoUsuario(Representante $representante) : ?int
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
