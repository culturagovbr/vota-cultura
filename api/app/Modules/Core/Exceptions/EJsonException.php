<?php

namespace App\Modules\Core\Exceptions;

use Exception;

abstract class EJsonException extends Exception
{
    public function report()
    {

    }

    public function render($request)
    {
        $retorno = ['message' => $this->getMessage()];
        $codigo = $this->getCode();
        return response()->json($retorno, $codigo);
    }
}
