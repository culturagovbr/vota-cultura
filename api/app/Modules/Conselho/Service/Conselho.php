<?php

namespace App\Modules\Conselho\Services;

use App\Core\Services\AbstractService;
use App\Modules\Conselho\Model\Conselho as ConselhoModel;
use DB;
use Illuminate\Http\Response;

class Conselho extends AbstractService
{
    public function __construct(ConselhoModel $model)
    {
        parent::__construct($model);
    }

    public function cadastrar(array $dados): ?ConselhoModel
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
                throw new \Exception(
                    'Conselho já cadastrado.',
                    Response::HTTP_NOT_ACCEPTABLE
                );
            }

            DB::beginTransaction();
            $conselho = ConselhoModel::create($dados);
//            Mail::to($conselho->ds_email)->send(
//                new CadastroComSucesso($conselho)
//            );
            DB::commit();
            return $conselho;
        } catch (\Exception $queryException) {
            DB::rollBack();
            throw $queryException;
        }
    }
}
