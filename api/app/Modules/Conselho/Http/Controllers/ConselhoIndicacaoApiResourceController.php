<?php

namespace App\Modules\Conselho\Http\Controllers;

use App\Modules\Conselho\Http\Resources\Conselho;
use App\Modules\Conselho\Service\ConselhoIndicacao;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Illuminate\Http\Response;

class ConselhoIndicacaoApiResourceController extends Controller
{
    private $service;
    public function __construct(ConselhoIndicacao $service)
    {
        $this->middleware('auth:api');
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): JsonResponse
    {
        return $this->sendResponse(
            Conselho::collection($this->service->obterTodos()),
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
        //
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
