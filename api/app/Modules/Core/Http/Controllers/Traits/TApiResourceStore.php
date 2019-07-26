<?php

namespace App\Modules\Core\Http\Controllers\Traits;

trait TApiResourceStore
{
    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        return $this->sendResponse($this->service->cadastrar($request->all()),
            "Operação Realizada com Sucesso",
            Response::HTTP_CREATED
        );
    }
}
