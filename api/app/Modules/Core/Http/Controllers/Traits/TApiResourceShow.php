<?php

namespace App\Modules\Core\Http\Controllers\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Response;

trait TApiResourceShow
{
    public function genericShow(Model $model): \Illuminate\Http\JsonResponse
    {
        return $this->sendResponse(
            $model->toArray(),
            "Operação realizada com sucesso",
            Response::HTTP_OK
        );
    }
}
