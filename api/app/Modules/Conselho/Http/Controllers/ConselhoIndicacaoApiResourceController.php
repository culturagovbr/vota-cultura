<?php

namespace App\Modules\Conselho\Http\Controllers;

use App\Modules\Conselho\Service\ConselhoIndicacao;
USE \App\Modules\Conselho\Http\Resources\ConselhoIndicacao as ConselhoIndicacaoResource;
use App\Modules\Core\Http\Controllers\AApiResourceController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

use Illuminate\Http\Response;

class ConselhoIndicacaoApiResourceController extends AApiResourceController
{
    /** @var ConselhoIndicacao ConselhoIndicacao  */
    protected $service;
    public function __construct(ConselhoIndicacao $service)
    {
        $this->middleware('auth:api');
        $this->service = $service;
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
            $this->service->cadastrar(collect($request->all())),
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
    public function show($id)
    {
        //
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
                return $this->sendResponse(
            new RecursoInscricaoResource(
                $this->service->atualizar($request, $identificador)
            ),
            "Operação realizada com sucesso",
            Response::HTTP_OK
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}