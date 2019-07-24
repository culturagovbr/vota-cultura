<?php

namespace App\Modules\Conselho\Http\Controllers;

use App\Modules\Conselho\Services\Conselho as ConselhoService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Modules\Conselho\Model\Conselho as ConselhoModel;
use Illuminate\Http\JsonResponse;

class ConselhoController extends Controller
{
    private $conselhoService;

    public function __construct(ConselhoService $conselhoService)
    {
        $this->conselhoService = $conselhoService;
    }

    public function store(Request $request) : JsonResponse
    {
        return $this->sendResponse($this->conselhoService->cadastrar($request->all()),
            "Operação Realizada com Sucesso",
            Response::HTTP_CREATED
        );
    }
}
