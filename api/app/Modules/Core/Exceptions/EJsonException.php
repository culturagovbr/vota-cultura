<?php

namespace App\Modules\Core\Exceptions;

use Exception;
use Illuminate\Support\Facades\Response;

abstract class EJsonException extends Exception
{
    public function report()
    {

    }

    public function render($request)
    {
        $retorno = ['message' => $this->getMessage()];
        $codigo = $this->getCode();
        if($codigo === 0) {
            $codigo = \Illuminate\Http\Response::HTTP_INTERNAL_SERVER_ERROR;
        }

        return Response::json($retorno, $codigo);
    }
}
