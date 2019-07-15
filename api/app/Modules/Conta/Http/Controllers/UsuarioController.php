<?php

namespace App\Modules\Conta\Http\Controllers;

use App\Modules\Conta\Services\Usuario as UsuarioService;
use App\Http\Controllers\Controller;

/**
 * UsuarioController
 *
 * @package App\Modules\Conta\Http\Controllers
 *
 * @OA\Post(
 *     path="/api/conta/usuario",
 *     tags={"Usuario"},
 *     summary="Cadastro de usuário",
 *     operationId="cadastrarUsuario",
 *     @OA\Response(
 *         response=405,
 *         description="Parametros inválidos"
 *     ),
 *     deprecated=false,
 *     @OA\RequestBody(
 *         description="Dados informados por formulário",
 *         @OA\MediaType(
 *             mediaType="application/x-www-form-urlencoded",
 *             @OA\Schema(
 *                 type="object",
 *                 @OA\Property(
 *                     property="no_cpf",
 *                     description="Número de CPF do usuário",
 *                     @OA\Schema(
 *                          type="string",
 *                          maximum=11,
 *                          minimum=11
 *                     ),
 *                 ),
 *                 @OA\Property(
 *                     property="no_email",
 *                     description="E-mail do usuário",
 *                     @OA\Schema(
 *                          type="string",
 *                          maximum=6,
 *                          minimum=255
 *                     ),
 *                 ),
 *                 @OA\Property(
 *                     property="ds_senha",
 *                     description="Senha do usuário",
 *                     @OA\Schema(
 *                          type="string",
 *                          maximum=1,
 *                          minimum=10
 *                     ),
 *                 ),
 *                 @OA\Property(
 *                     property="dt_nascimento",
 *                     description="Data de nascimento do usuário",
 *                     type="date",
 *                 ),
 *                 @OA\Property(
 *                     property="no_nome",
 *                     description="Senha do usuário",
 *                     @OA\Schema(
 *                          type="string",
 *                          maximum=1,
 *                          minimum=10
 *                     ),
 *                 )
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Operação Realizada com Sucesso",
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Dados inválidos"
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="É necessário estar autenticado para ter acesso a essa funcionalidade."
 *     ),
 * )
 * )
 */

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
