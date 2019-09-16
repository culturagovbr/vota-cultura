<?php

namespace App\Modules\Localidade\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Localidade\Service\Municipio as MunicipioService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class MunicipioController extends Controller
{
    /**
     * @var MunicipioService
     */
    protected $service;

    public function __construct(MunicipioService $service)
    {
        $this->service = $service;
    }

    public function show($identificador): JsonResponse
    {
        return $this->sendResponse(
            $this->service->obterPorUF((int)$identificador),
            "Operação realizada com sucesso",
            Response::HTTP_OK
        );
    }
}
