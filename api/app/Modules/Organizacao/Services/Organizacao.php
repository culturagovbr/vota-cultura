<?php

namespace App\Modules\Conta\Services;

use App\Exceptions\ValidacaoCustomizadaException;
use App\Modules\Conta\Mail\Organizacao\CadastroComSucesso;
use App\Modules\Conta\Model\Perfil;
use App\Services\AbstractService;
use App\Modules\Conta\Model\Organizacao as OrganizacaoModel;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use DB;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class Organizacao extends AbstractService
{
    public function __construct(OrganizacaoModel $model)
    {
        parent::__construct($model);
    }

    public function cadastrar(array $dados)
    {
        try {
            $organizacao = $this->getModel()->where([
                'ds_email' => $dados['ds_email']
            ])->orWhere([
                'no_organizacao' => $dados['no_orgao_gestor']
            ])->orWhere([
                'nu_cnpj' => $dados['nu_cnpj']
            ])->first();

            if ($organizacao) {
                throw new ValidacaoCustomizadaException(
                    'Organizacao já cadastrado.',
                    Response::HTTP_NOT_ACCEPTABLE
                );
            }

            DB::beginTransaction();
            $organizacao = $this->getModel();
            $organizacao->fill($dados);
            $organizacao->save();

//            Mail::to($organizacao->ds_email)->send(
//                new CadastroComSucesso($organizacao)
//            );
            DB::commit();
            return $organizacao;
        } catch (\Exception $queryException) {
            DB::rollBack();
            throw $queryException;
        }
    }

}
