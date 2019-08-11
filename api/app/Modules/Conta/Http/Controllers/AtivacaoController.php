<?php

namespace App\Modules\Conta\Http\Controllers;


use App\Modules\Conta\Service\Usuario as UsuarioService;
use App\Http\Controllers\Controller;

class AtivacaoController extends Controller
{

    private $usuarioService;

    public function __construct(UsuarioService $usuarioService)
    {
        $this->usuarioService = $usuarioService;
    }

    public function update($codigo_ativacao) : \Illuminate\Http\JsonResponse
    {
        return $this->sendResponse($this->usuarioService->ativarUsuarioPorCodigoAtivacao($codigo_ativacao));
    }

}
