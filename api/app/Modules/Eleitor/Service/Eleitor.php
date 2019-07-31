<?php

namespace App\Modules\Eleitor\Service;

use App\Core\Service\AbstractService;
use App\Modules\Localizacao\Service\Endereco;
use App\Modules\Eleitor\Model\Eleitor as EleitorModel;
use App\Modules\Representacao\Service\Representante;
use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Http\Response;

class Eleitor extends AbstractService
{
    public function __construct(EleitorModel $model)
    {
        parent::__construct($model);
    }

    public function cadastrar(array $dados): ?Model
    {
        try {
            $eleitor = $this->getModel()->where([
                'no_eleitor' => $dados['no_orgao_gestor']
            ])->orWhere([
                'nu_cnpj' => $dados['nu_cnpj']
            ])->first();

            if ($eleitor) {
                throw new \HttpException(
                    'Eleitor já cadastrado.',
                    Response::HTTP_NOT_ACCEPTABLE
                );
            }

            $serviceEndereco = app()->make(Endereco::class);
            $endereco = $serviceEndereco->cadastrar($dados);

            if (!$endereco) {
                throw new \HttpException('Não foi possível cadastrar o representante.');
            }
            $dados['co_endereco'] = $endereco->co_endereco;

            $eleitor = parent::cadastrar($dados);

//            Mail::to($eleitor->ds_email)->send(
//                new CadastroComSucesso($eleitor)
//            );
            return $eleitor;
        } catch (\Exception $queryException) {
            DB::rollBack();
            throw $queryException;
        }
    }

}
