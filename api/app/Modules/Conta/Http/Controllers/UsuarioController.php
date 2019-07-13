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

    public function index() : \Illuminate\Http\JsonResponse
    {
        return $this->sendResponse($this->usuarioService->obterTodos());
    }

    public function show($co_usuario) : \Illuminate\Http\JsonResponse
    {
        return $this->sendResponse($this->usuarioService->obterUm($co_usuario));
    }

    public function store() : \Illuminate\Http\JsonResponse
    {
        return $this->sendResponse($this->usuarioService->cadastrar());
    }

    public function update($codigo_ativacao) : \Illuminate\Http\JsonResponse
    {
        return $this->sendResponse($this->usuarioService->ativarUsuarioPorCodigoAtivacao($codigo_ativacao));
    }
}
