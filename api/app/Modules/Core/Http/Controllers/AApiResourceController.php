<?php

namespace App\Modules\Core\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Core\Services\IServiceApiResource;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

abstract class AApiResourceController extends Controller implements IApiResourceController
{
    protected $service;

    public function __construct(IServiceApiResource $service)
    {
        $this->service = $service;
    }

    public function index() : \Illuminate\Http\JsonResponse
    {
        return $this->sendResponse(
            $this->service->obterTodos(),
            "Operação Realizada com Sucesso",
            Response::HTTP_OK
        );
    }

    public function show(Model $model) : \Illuminate\Http\JsonResponse
    {
        return $this->sendResponse(
            $model->toArray(),
            "Operação Realizada com Sucesso",
            Response::HTTP_OK
        );
    }

    public function store(Request $request) : \Illuminate\Http\JsonResponse
    {
        return $this->sendResponse($this->service->cadastrar($request->all()),
            "Operação Realizada com Sucesso",
            Response::HTTP_CREATED
        );
    }

    public function update(Request $request, $identificador)
    {
        return $this->sendResponse(
            $this->service->atualizar($request, $identificador),
            "Operação Realizada com Sucesso",
            Response::HTTP_OK
        );
    }

    public function destroy(Request $request, $identificador)
    {
        $this->service->remover($request, $identificador);

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
