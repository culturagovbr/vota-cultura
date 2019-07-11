<?php
namespace App\Exceptions;

use Exception;

class ValidacaoCustomizadaException extends Exception
{
    public function report()
    {

    }

    public function render($request)
    {
        $retorno = ['message' => $this->getMessage()];
        $codigo = $this->getCode();
        return response()->json($retorno,$codigo);
    }
}
