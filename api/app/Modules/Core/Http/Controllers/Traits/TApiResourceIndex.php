<?php

namespace App\Modules\Core\Http\Controllers\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

trait TApiResourceIndex
{
    public function index(): JsonResponse
    {
        return $this->sendResponse(
            $this->service->obterTodos(),
            "Operação Realizada com Sucesso",
            Response::HTTP_OK
        );
    }
}
