<?php

namespace App\Modules\Fase\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Fase\Service\Fase as FaseService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class FaseController extends Controller
{
    /**
     * @var FaseService $service
     */
    protected $service;

    public function __construct(FaseService $service)
    {
        $this->service = $service;
    }

    public function index(): JsonResponse
    {
        return $this->sendResponse(
            $this->service->obterDisponiveis(),
            "Operação realizada com sucesso",
            Response::HTTP_OK
        );
    }
}
