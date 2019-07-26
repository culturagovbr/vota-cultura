<?php

namespace App\Modules\Core\Http\Controllers\Traits;

trait TApiResourceShow
{
    public function show(Model $model): \Illuminate\Http\JsonResponse
    {
        return $this->sendResponse(
            $model->toArray(),
            "Operação Realizada com Sucesso",
            Response::HTTP_OK
        );
    }
}
