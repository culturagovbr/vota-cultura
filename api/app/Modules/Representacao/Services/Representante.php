<?php

namespace App\Modules\Representacao\Services;

use App\Core\Services\AbstractService;
use App\Modules\Representacao\Model\Representante as RepresentanteModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Response;

class Representante extends AbstractService
{
    public function __construct(RepresentanteModel $model)
    {
        parent::__construct($model);
    }

    public function cadastrar(array $dados): ?Model
    {
        try {
            $representante = $this->getModel()->where([
                'ds_email' => $dados['ds_email']
            ])->orWhere([
                'no_organizacao' => $dados['no_orgao_gestor']
            ])->orWhere([
                'nu_rg' => $dados['nu_rg']
            ])->orWhere([
                'nu_cpf' => $dados['nu_cpf']
            ])->first();

            if ($representante) {
                throw new \Exception(
                    'Representante já cadastrado.',
                    Response::HTTP_NOT_ACCEPTABLE
                );
            }

            return parent::cadastrar($dados);
        } catch (\Exception $queryException) {
            DB::rollBack();
            throw $queryException;
        }
    }

}
