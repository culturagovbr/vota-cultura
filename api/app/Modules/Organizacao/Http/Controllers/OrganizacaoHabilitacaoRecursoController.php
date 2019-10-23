<?php

namespace App\Modules\Organizacao\Http\Controllers;

use App\Modules\Organizacao\Service\OrganizacaoHabilitacaoRecurso;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Illuminate\Http\Response;

class OrganizacaoHabilitacaoRecursoController extends Controller
{

    /**
     * @var OrganizacaoHabilitacaoRecurso
     */
    protected $service;

    public function __construct(OrganizacaoHabilitacaoRecurso $service)
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
        if(!$request->method) {
            return $this->sendResponse(
                $this->service->cadastrarHabilitacaoRecurso($request->only(['dsRecurso'])),
                'Operação realizada com sucesso',
                Response::HTTP_CREATED
            );
        }

        return $this->sendResponse(
            $this->service->alterarHabilitacaoRecurso($request),
            'Operação realizada com sucesso',
            Response::HTTP_CREATED
        );
    }
}
