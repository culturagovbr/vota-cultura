<?php

namespace App\Modules\Conselho\Service;

use App\Core\Service\AbstractService;
use App\Modules\Conselho\Model\Conselho as ConselhoModel;
use App\Modules\Localizacao\Service\Endereco;
use App\Modules\Representacao\Service\Representante;
use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Response;

class Conselho extends AbstractService
{
    public function __construct(ConselhoModel $model)
    {
        parent::__construct($model);
    }

    public function cadastrar(array $dados): ?Model
    {
        try {
            $conselho = $this->getModel()->where([
                'ds_email' => $dados['ds_email']
            ])->orWhere([
                'no_orgao_gestor' => $dados['no_orgao_gestor']
            ])->orWhere([
                'nu_cnpj' => $dados['nu_cnpj']
            ])->first();

            if ($conselho) {
                throw new \HttpException(
                    'Conselho já cadastrado.',
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

            $dados['co_endereco'] = $endereco->co_endereco;
            $conselho = parent::cadastrar($dados);

//            Mail::to($organizacao->ds_email)->send(
//                new CadastroComSucesso($organizacao)
//            );
            return $conselho;
        } catch (\Exception $queryException) {
            DB::rollBack();
            throw $queryException;
        }
    }
}
