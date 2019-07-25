<?php

namespace App\Modules\Representacao\Services;
use App\Services\AbstractService;


class Representante extends AbstractService
{
    public function __construct(RepresentanteModel $model)
    {
        parent::__construct($model);
    }

    public function cadastrar(array $dados)
    {
        try {
            $representante = $this->getModel()->where([
                'ds_email' => $dados['ds_email']
            ])->orWhere([
                'no_organizacao' => $dados['no_orgao_gestor']
            ])->orWhere([
                'nu_cnpj' => $dados['nu_cnpj']
            ])->first();

            if ($representante) {
                throw new ValidacaoCustomizadaException(
                    'Representante já cadastrado.',
                    Response::HTTP_NOT_ACCEPTABLE
                );
            }

            DB::beginTransaction();
            $representante = $this->getModel();
            $representante->fill($dados);
            $representante->save();

            DB::commit();
            return $representante;
        } catch (\Exception $queryException) {
            DB::rollBack();
            throw $queryException;
        }
    }

}
