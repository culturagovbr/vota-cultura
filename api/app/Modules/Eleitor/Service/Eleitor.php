<?php

namespace App\Modules\Eleitor\Service;

use App\Core\Service\AbstractService;
use App\Modules\Core\Exceptions\EParametrosInvalidos;
use App\Modules\Eleitor\Mail\Eleitor\CadastroComSucesso;
use App\Modules\Eleitor\Model\Eleitor as EleitorModel;
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

            $eleitor = parent::cadastrar($dados);

            Mail::to($eleitor->ds_email)
                ->bcc(env('EMAIL_ACOMPANHAMENTO'))
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
