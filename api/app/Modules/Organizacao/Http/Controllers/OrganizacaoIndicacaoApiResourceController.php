<?php

namespace App\Modules\Organizacao\Http\Controllers;

use App\Modules\Organizacao\Http\Resources\OrganizacaoIndicacao as OrganizacaoIndicacaoResource;
use App\Modules\Organizacao\Service\Organizacao as OrganizacaoService;
use App\Modules\Organizacao\Service\OrganizacaoHabilitacaoRecurso;
use App\Modules\Organizacao\Service\OrganizacaoIndicacao as OrganizacaoIndicacaoService;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Illuminate\Http\Response;

class OrganizacaoIndicacaoApiResourceController extends Controller
{

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
    public function index()
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
    public function store(Request $request)
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
