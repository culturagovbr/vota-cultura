<?php

namespace App\Modules\Conselho\Http\Controllers;

use App\Modules\Conselho\Service\ConselhoRecursoHabilitacao;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;

class ConselhoRecursoHabilitacaoController extends Controller
{

    /**
     * @var ConselhoRecursoHabilitacao
     */
    protected $service;

    public function __construct(ConselhoRecursoHabilitacao $service)
    {
        $this->service = $service;
        $this->middleware('auth:api');
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws \App\Modules\Core\Exceptions\EParametrosInvalidos
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function store(Request $request)
    {
       return $this->sendResponse(
           $this->service->cadastrarRecursoHabilitacao($request->only(['dsRecurso', 'anexo'])),
           'Operação realizada com sucesso',
           Response::HTTP_CREATED
       );
    }
}
