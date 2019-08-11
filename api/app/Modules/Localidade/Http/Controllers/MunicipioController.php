<?php

namespace App\Modules\Localidade\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Localidade\Service\Municipio as MunicipioService;
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

    public function show($identificador): \Illuminate\Http\JsonResponse
    {
        return $this->sendResponse(
            $this->service->obterPorUF($identificador),
            "Operação Realizada com Sucesso",
            Response::HTTP_OK
        );
    }
}
