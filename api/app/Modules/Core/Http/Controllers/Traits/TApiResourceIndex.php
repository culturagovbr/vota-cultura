<?php

namespace App\Modules\Core\Http\Controllers\Traits;

trait TApiResourceIndex
{
    public function index(): \Illuminate\Http\JsonResponse
    {
        return $this->sendResponse(
            $this->service->obterTodos(),
            "Operação Realizada com Sucesso",
            Response::HTTP_OK
        );
    }
}
