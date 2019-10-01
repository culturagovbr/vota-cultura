<?php

namespace App\Modules\Conselho\Http\Controllers;

use App\Modules\Conselho\Service\ConselhoHabilitacaoRecurso;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;

class ConselhoHabilitacaoRecursoController extends Controller
{

    /**
     * @var ConselhoHabilitacaoRecurso
     */
    protected $service;

    public function __construct(ConselhoHabilitacaoRecurso $service)
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
           $this->service->cadastrarHabilitacaoRecurso($request->only(['dsRecurso', 'anexo'])),
           'Operação realizada com sucesso',
           Response::HTTP_CREATED
       );
    }
}
