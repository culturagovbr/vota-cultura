<?php

namespace App\Modules\Conta\Http\Controllers;


use App\Modules\Conta\Services\Usuario as UsuarioService;
use App\Http\Controllers\Controller;

class UsuarioController extends Controller
{

    private $usuarioService;

    public function __construct(UsuarioService $usuarioService)
    {
        $this->usuarioService = $usuarioService;
    }

    public function show($co_usuario) : \Illuminate\Http\JsonResponse
    {
        return $this->sendResponse($this->usuarioService->find($co_usuario));
    }

}
