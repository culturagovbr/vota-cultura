<?php

namespace App\Modules\Conta\Http\Controllers;


use App\Modules\Conta\Services\Usuario;

class AtivacaoController extends \App\Http\Controllers\Controller
{

    private $usuarioService;

    public function __construct(Usuario $usuarioService)
    {
        $this->usuarioService = $usuarioService;
    }

    public function update($codigo_ativacao) : \Illuminate\Http\JsonResponse
    {
        return response()->json($this->usuarioService->ativarUsuarioPorCodigoAtivacao($codigo_ativacao));
    }

}
