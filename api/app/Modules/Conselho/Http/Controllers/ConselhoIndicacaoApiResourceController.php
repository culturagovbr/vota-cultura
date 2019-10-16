<?php

namespace App\Modules\Conselho\Http\Controllers;

use App\Modules\Conselho\Service\ConselhoIndicacao;
USE \App\Modules\Conselho\Http\Resources\ConselhoIndicacao as ConselhoIndicacaoResource;
use App\Modules\Core\Http\Controllers\AApiResourceController;
use App\Modules\Core\Http\Controllers\Traits\TApiResourceDestroy;
use App\Modules\Core\Http\Controllers\Traits\TApiResourceUpdate;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

use Illuminate\Http\Response;

class ConselhoIndicacaoApiResourceController extends AApiResourceController
{
    use TApiResourceUpdate,
        TApiResourceDestroy;

    /** @var ConselhoIndicacao ConselhoIndicacao  */
    protected $service;
    public function __construct(ConselhoIndicacao $service)
    {
        $this->middleware('auth:api');
        return parent::__construct($service);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): JsonResponse
    {
        return $this->sendResponse(
            ConselhoIndicacaoResource::collection($this->service->obterTodos()),
            "Operação realizada com sucesso",
            Response::HTTP_OK
        );
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws \App\Modules\Core\Exceptions\EParametrosInvalidos
     */
    public function store(Request $request): JsonResponse
    {
        return $this->sendResponse(
            $this->service->cadastrar(
                collect($request->all())),
            "Operação realizada com sucesso",
            Response::HTTP_CREATED
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id): JsonResponse
    {
        return $this->sendResponse(
            new ConselhoIndicacaoResource(
                $this->service->obterUm($id)
            ),
            "Operação realizada com sucesso",
            Response::HTTP_OK
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * @param Request $request
     * @param $id
     * @return JsonResponse
     * @throws \HttpException
     */
    public function update(Request $request, $id)
    {
        return $this->sendResponse(
            new ConselhoIndicacaoResource(
                $this->service->atualizar($request, $id)
            ),
            "Operação realizada com sucesso",
            Response::HTTP_OK
        );
    }

    /**
     * @param Request $request
     * @param $id
     * @return JsonResponse
     * @throws \HttpException
     */
    public function destroy(Request $request, $id)
    {
        $this->service->remover($request, $id);
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
