<?php

namespace App\Modules\Organizacao\Http\Controllers;

use App\Modules\Core\Http\Controllers\AApiResourceController;
use App\Modules\Core\Http\Controllers\Traits\TApiResourceDestroy;
use App\Modules\Organizacao\Http\Resources\OrganizacaoIndicacao as OrganizacaoIndicacaoResource;
use App\Modules\Organizacao\Service\OrganizacaoIndicacao as OrganizacaoIndicacaoService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class OrganizacaoIndicacaoApiResourceController extends AApiResourceController
{
    use TApiResourceDestroy;
    /**
     * @var OrganizacaoIndicacao
     */
    protected $service;

    public function __construct(OrganizacaoIndicacaoService $service)
    {
        $this->service = $service;
        $this->middleware('auth:api');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): JsonResponse
    {
        $organizacaoService = app(OrganizacaoIndicacaoService::class, request()->all());
        return $this->sendResponse(
            OrganizacaoIndicacaoResource::collection($organizacaoService->obterTodos()),
            "Operação realizada com sucesso",
            Response::HTTP_OK
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Modules\Core\Exceptions\EParametrosInvalidos
     * @throws \HttpException
     */
    public function store(Request $request): JsonResponse
    {
        return $this->sendResponse(
            $this->service->cadastrar(collect($request->all())),
            'Operação realizada com sucesso',
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
        //
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
