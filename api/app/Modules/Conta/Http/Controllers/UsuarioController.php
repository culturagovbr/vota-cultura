<?php

namespace App\Modules\Conta\Http\Controllers;

use App\Modules\Conta\Http\Resources\Usuario as UsuarioResource;
use App\Modules\Conta\Service\Usuario as UsuarioService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Modules\Conta\Model\Usuario as UsuarioModel;


class UsuarioController extends Controller
{

    private $usuarioService;

    public function __construct(UsuarioService $usuarioService)
    {
        $this->usuarioService = $usuarioService;
        $this->middleware('auth:api', ['except' => [
            'index',
            'show',
            'store',
            'listarUsuarios'
        ]]);
    }

    public function index() : \Illuminate\Http\JsonResponse
    {
        return $this->sendResponse(
            $this->usuarioService->obterTodos(),
            "Operação realizada com sucesso",
            Response::HTTP_OK
        );
    }

    public function show(UsuarioModel $usuario) : \Illuminate\Http\JsonResponse
    {
        return $this->sendResponse(
            $usuario->toArray(),
            "Operação realizada com sucesso",
            Response::HTTP_OK
        );
    }

    public function store(Request $request) : \Illuminate\Http\JsonResponse
    {
        return $this->sendResponse(
            new UsuarioResource(
                $this->usuarioService->cadastrar(collect($request->all()))
            ),
            "Operação realizada com sucesso",
            Response::HTTP_CREATED
        );
    }

    public function update(Request $request, $co_usuario)
    {
        return $this->sendResponse(
            new UsuarioResource(
                $this->usuarioService->atualizar($request, $co_usuario)
            ),
            "Operação realizada com sucesso",
            Response::HTTP_OK
        );
    }

    public function destroy(UsuarioModel $usuario)
    {
        $this->usuarioService->remover($usuario);

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }

    public function alterarSenha(Request $request, $co_usuario)
    {
        return $this->sendResponse(
            $this->usuarioService->alterarSenha($request, $co_usuario),
            "Operação realizada com sucesso",
            Response::HTTP_OK
        );
    }

    public function listarUsuarios(Request $request): \Illuminate\Http\JsonResponse
    {
        return $this->sendResponse(
            UsuarioResource::collection($this->usuarioService->obterTodosComPerfis($request)),
            "Operação realizada com sucesso",
            Response::HTTP_OK
        );
    }
}
