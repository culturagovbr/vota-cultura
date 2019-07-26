<?php

namespace App\Core\Services;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

abstract class AbstractService implements IService
{
    private $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function getModel() : ?Model
    {
        return $this->model;
    }

    public function obterUm($identificador) : ?Model
    {
        return $this->getModel()->find($identificador);
    }

    public function obterTodos() : ?Collection
    {
        return $this->getModel()->get();
    }

    public function atualizar(Request $request, int $identificador)
    {
//        try {
//            $model = $this->getModel()->find($identificador);
//            if (!$model) {
//                throw new \Exception(
//                    'Dadis não encontrados.',
//                    Response::HTTP_NOT_ACCEPTABLE
//                );
//            }
//            DB::beginTransaction();
//            $model->fill($request->all());
//            $model->save();
//            DB::commit();
//            return $model->toArray();
//        } catch (\Exception $queryException) {
//            DB::rollBack();
//            throw $queryException;
//        }
        throw new \Exception("Método não implementado");
    }

    public function remover(Request $request, int $identificador)
    {
//        try {
//            $model = $this->getModel()->find($identificador);
//            if (!$model) {
//                throw new ValidacaoCustomizadaException(
//                    'Dados não localizados.',
//                    Response::HTTP_NOT_ACCEPTABLE
//                );
//            }
//
//            DB::beginTransaction();
//            $model->delete();
//            DB::commit();
//        } catch (\Exception $queryException) {
//            DB::rollBack();
//            throw $queryException;
//        }
        throw new \Exception("Método não implementado");
    }
}
