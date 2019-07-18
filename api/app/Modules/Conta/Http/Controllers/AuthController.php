<?php

namespace App\Modules\Conta\Http\Controllers;

/**
 * AuthController
 *
 * @package App\Modules\Conta\Http\Controllers
 *
 * @OA\Post(
 *     path="/api/conta/auth/login",
 *     tags={"Autenticacao"},
 *     summary="Realizar login na aplicação",
 *     operationId="realizarLogin",
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
 *                     type="string",
 *                 ),
 *                 @OA\Property(
 *                     property="ds_senha",
 *                     description="Senha do usuário",
 *                     type="string"
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
 *
 * @OA\Post(
 *     path="/api/conta/auth/logout",
 *     tags={"Autenticacao"},
 *     summary="Realizar logout na aplicação",
 *     operationId="realizarLogout",
 *     @OA\Response(
 *         response=405,
 *         description="Parametros inválidos"
 *     ),
 *     deprecated=false,
 *     security={
 *         {"bearerAuth": {}}
 *     },
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
 *
 * @OA\Post(
 *     path="/api/conta/auth/refresh",
 *     tags={"Autenticacao"},
 *     summary="Atualizar Token JWT",
 *     operationId="atualizarToken",
 *     @OA\Response(
 *         response=405,
 *         description="Parametros inválidos"
 *     ),
 *     deprecated=false,
 *     security={
 *         {"bearerAuth": {}}
 *     },
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
 *
 * @OA\Get(
 *     path="/api/conta/auth/me",
 *     tags={"Autenticacao"},
 *     summary="Obtém as informações da token do usuário",
 *     operationId="obterInformacoesTokenAtiva",
 *     @OA\Response(
 *         response=405,
 *         description="Parametros inválidos"
 *     ),
 *     deprecated=false,
 *     security={
 *         {"bearerAuth": {}}
 *     },
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
class AuthController extends \App\Http\Controllers\Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    public function login(): \Illuminate\Http\JsonResponse
    {
        $credentials = request()->only(['no_cpf', 'ds_senha']);

        if (!$token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Sem autorização.'], 401);
        }

        return $this->respondWithToken($token);
    }

    public function me(): \Illuminate\Http\JsonResponse
    {
        return response()->json(auth()->user());
    }

    public function logout(): \Illuminate\Http\JsonResponse
    {
        auth()->logout();

        return response()->json(['message' => 'Logout realizado com sucesso']);
    }

    public function refresh(): \Illuminate\Http\JsonResponse
    {
        return $this->respondWithToken(auth()->refresh());
    }

    protected function respondWithToken(string $token): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}
