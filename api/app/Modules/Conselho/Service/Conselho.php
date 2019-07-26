<?php

namespace App\Modules\Conselho\Services;

use App\Exceptions\ValidacaoCustomizadaException;
use App\Core\Services\AbstractService;
use App\Modules\Conselho\Model\Conselho as ConselhoModel;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

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


    public function atualizar(Request $request, int $identificador): ?ConselhoModel
    {
        try {
            $model = $this->getModel()->find($identificador);
            if (!$model) {
                throw new \Exception(
                    'Dadis não encontrados.',
                    Response::HTTP_NOT_ACCEPTABLE
                );
            }
            DB::beginTransaction();
            $model->fill($request->all());
            $model->save();
            DB::commit();
            return $model->toArray();
        } catch (\Exception $queryException) {
            DB::rollBack();
            throw $queryException;
        }
    }

    public function remover(Request $request, int $identificador)
    {
        try {
            $model = $this->getModel()->find($identificador);
            if (!$model) {
                throw new ValidacaoCustomizadaException(
                    'Dados não localizados.',
                    Response::HTTP_NOT_ACCEPTABLE
                );
            }

            DB::beginTransaction();
            $model->delete();
            DB::commit();
        } catch (\Exception $queryException) {
            DB::rollBack();
            throw $queryException;
        }
    }
}
