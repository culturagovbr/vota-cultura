<?php

namespace App\Modules\Core\Http\Controllers\Traits;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

trait TApiResourceStore
{
    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        return $this->sendResponse(
            $this->service->cadastrar(collect($request->all())),
            "Operação realizada com sucesso",
            Response::HTTP_CREATED
        );
    }
}
