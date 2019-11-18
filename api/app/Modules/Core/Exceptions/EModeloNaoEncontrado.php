<?php

namespace App\Modules\Core\Exceptions;

use Illuminate\Database\Eloquent\ModelNotFoundException;

class EModeloNaoEncontrado extends ModelNotFoundException
{
    public function render($request)
    {
        $retorno = [
            'message' => 'Nenhum registro encontrado com os dados enviados.',
            'data' => NULL
        ];

        $codigo = $this->getCode();
        if($codigo === 0) {
            $codigo = \Illuminate\Http\Response::HTTP_INTERNAL_SERVER_ERROR;
        }

        return response()->json($retorno, $codigo);
    }
}