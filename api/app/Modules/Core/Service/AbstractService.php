<?php

namespace App\Core\Service;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

abstract class AbstractService implements IServiceApiResource
{
    protected $model;

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
        try {
            $modelPesquisada = $this->getModel()->find($identificador);
            if (!$modelPesquisada) {
                throw new \HttpException(
                    'Dados não encontrados.',
                    Response::HTTP_NOT_ACCEPTABLE
                );
            }
            DB::beginTransaction();
            $modelPesquisada->fill($request->all());
            $modelPesquisada->save();
            DB::commit();
            return $modelPesquisada->toArray();
        } catch (\HttpException $queryException) {
            DB::rollBack();
            throw $queryException;
        }
    }

    public function remover(Request $request, int $identificador)
    {
        try {
            $modelPesquisada = $this->getModel()->find($identificador);
            if (!$modelPesquisada) {
                throw new \HttpException(
                    'Dados não localizados.',
                    Response::HTTP_NOT_ACCEPTABLE
                );
            }

            DB::beginTransaction();
            $modelPesquisada->delete();
            DB::commit();
        } catch (\HttpException $queryException) {
            DB::rollBack();
            throw $queryException;
        }
    }

    public function cadastrar(Collection $dados): ?Model
    {
        try {
            DB::beginTransaction();
            $modelPesquisada = $this->getModel()->fill($dados->toArray());
            $modelPesquisada->save();
            DB::commit();
            return $modelPesquisada;
        } catch (\HttpException $queryException) {
            DB::rollBack();
            throw $queryException;
        }
    }
}
