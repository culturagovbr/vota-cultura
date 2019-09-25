<?php

namespace App\Modules\Conselho\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Conselho\Http\Resources\Conselho;
use App\Modules\Conselho\Http\Resources\ConselhoHabilitacao;
use App\Modules\Conselho\Service\Conselho as ConselhoService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;


class ConselhoListaHabilitacaoController extends Controller
{

    /**
     * @var ConselhoService
     */
    protected $service;

    public function __construct(ConselhoService $service)
    {
        $this->service = $service;
        $this->middleware('auth:api');
    }

    public function index(): JsonResponse
    {
        return $this->sendResponse(
            ConselhoHabilitacao::collection($this->service->obterTodos()),
            "Operação realizada com sucesso",
            Response::HTTP_OK
        );
    }
}
