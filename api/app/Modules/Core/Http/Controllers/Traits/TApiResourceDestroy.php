<?php

namespace App\Modules\Core\Http\Controllers\Traits;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

trait TApiResourceDestroy
{
    public function destroy(Request $request, $identificador)
    {
        $this->service->remover($request, $identificador);
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
