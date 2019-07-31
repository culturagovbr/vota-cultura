<?php

namespace App\Modules\Organizacao\Services;

use App\Core\Services\AbstractService;
use App\Modules\Localizacao\Services\Endereco;
use App\Modules\Organizacao\Model\Organizacao as OrganizacaoModel;
use App\Modules\Representacao\Services\Representante;
use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Http\Response;

class Organizacao extends AbstractService
{
    public function __construct(OrganizacaoModel $model)
    {
        parent::__construct($model);
    }

    public function cadastrar(array $dados): ?Model
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
                throw new \HttpException(
                    'Organizacao já cadastrado.',
                    Response::HTTP_NOT_ACCEPTABLE
                );
            }

            $serviceRepresentante = app()->make(Representante::class);
            $representante = $serviceRepresentante->cadastrar($dados);

            if (!$representante) {
                throw new \HttpException('Não foi possível cadastrar o representante.');
            }

            $dados['co_representante'] = $representante->co_representante;
            $serviceEndereco = app()->make(Endereco::class);
            $endereco = $serviceEndereco->cadastrar($dados);

            if (!$endereco) {
                throw new \HttpException('Não foi possível cadastrar o representante.');
            }
            $dados['co_endereco'] = $representante->co_endereco;

            $organizacao = parent::cadastrar($dados);

//            Mail::to($organizacao->ds_email)->send(
//                new CadastroComSucesso($organizacao)
//            );
            return $organizacao;
        } catch (\Exception $queryException) {
            DB::rollBack();
            throw $queryException;
        }
    }

}
