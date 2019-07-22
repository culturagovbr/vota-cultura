<?php

namespace App\Modules\Conta\Http\Controllers;

use App\Modules\Conta\Services\Usuario as UsuarioService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Modules\Conta\Model\Usuario as UsuarioModel;

/**
 * UsuarioController
 *
 * @package App\Modules\Conta\Http\Controllers
 *
 * @OA\Post(
 *          path="/api/conta/usuario",
 *          tags={"Usuario"},
 *          summary="Cadastro de usuário",
 *          operationId="cadastrarUsuario",
 *          @OA\Response(
 *              response=405,
 *              description="Parametros inválidos"
 *          ),
 *          deprecated=false,
 *          @OA\RequestBody(
 *              description="Dados informados por formulário",
 *              @OA\MediaType(
 *                  mediaType="application/x-www-form-urlencoded",
 *                  @OA\Schema(
 *                      type="object",
 *                      @OA\Property(
 *                          property="no_cpf",
 *                          description="Número de CPF do usuário",
 *                          example="00000000000",
 *                          @OA\Schema(
 *                               type="string",
 *                               maximum=11,
 *                               minimum=11,
 *                          ),
 *                      ),
 *                      @OA\Property(
 *                          property="no_email",
 *                          description="E-mail do usuário",
 *                          example="usuario@mail.com",
 *                          @OA\Schema(
 *                               type="string",
 *                               maximum=6,
 *                               minimum=255
 *                          ),
 *                      ),
 *                      @OA\Property(
 *                          property="ds_senha",
 *                          description="Senha do usuário",
 *                          example="00000000000",
 *                          @OA\Schema(
 *                               type="string",
 *                               maximum=1,
 *                               minimum=10
 *                          ),
 *                      ),
 *                      @OA\Property(
 *                          property="dt_nascimento",
 *                          description="Data de nascimento do usuário",
 *                          type="date",
 *                          example="2019-06-30",
 *                      ),
 *                      @OA\Property(
 *                          property="no_nome",
 *                          description="Nome do usuário",
 *                          example="Usuário de teste",
 *                          @OA\Schema(
 *                               type="string",
 *                               maximum=1,
 *                               minimum=10
 *                          ),
 *                      )
 *                  )
 *              )
 *          ),
 *          @OA\Response(
 *              response=200,
 *              description="Operação Realizada com Sucesso",
 *          ),
 *          @OA\Response(
 *              response=400,
 *              description="Dados inválidos"
 *          ),
 *          @OA\Response(
 *              response=401,
 *              description="É necessário estar autenticado para ter acesso a essa funcionalidade."
 *          ),
 *      )
 * )
 *
 *  @OA\Get(
 *          path="/api/conta/usuario/{co_usuario}",
 *          tags={"Usuario"},
 *          summary="Obtém as informações de um usuário específico",
 *          operationId="obterInformacoesUsuario",
 *          @OA\Parameter(
 *              name="co_usuario",
 *              in="path",
 *              required=true,
 *              @OA\Schema(
 *                  type="integer",
 *                  format="int32",
 *              )
 *          ),
 *          @OA\Response(
 *              response=405,
 *              description="Parametros inválidos"
 *          ),
 *          deprecated=false,
 *          security={
 *              {"bearerAuth": {}}
 *          },
 *          @OA\Response(
 *              response=200,
 *              description="Operação Realizada com Sucesso",
 *          ),
 *          @OA\Response(
 *              response=400,
 *              description="Dados inválidos"
 *          ),
 *          @OA\Response(
 *              response=401,
 *              description="É necessário estar autenticado para ter acesso a essa funcionalidade."
 *          ),
 *      )
 * )
 *
 *  @OA\Get(
 *          path="/api/conta/usuario",
 *          tags={"Usuario"},
 *          summary="Obtém as informações de todos os usuários",
 *          operationId="obterInformacoesUsuarios",
 *          @OA\Response(
 *              response=405,
 *              description="Parametros inválidos"
 *          ),
 *          deprecated=false,
 *          security={
 *              {"bearerAuth": {}}
 *          },
 *          @OA\Response(
 *              response=200,
 *              description="Operação Realizada com Sucesso",
 *          ),
 *          @OA\Response(
 *              response=400,
 *              description="Dados inválidos"
 *          ),
 *          @OA\Response(
 *              response=401,
 *              description="É necessário estar autenticado para ter acesso a essa funcionalidade."
 *          ),
 *      )
 * )
 *
 * * @OA\Put(
 *     path="/api/conta/usuario/{co_usuario}",
 *     summary="Atualização de Usuário.",
 *     tags={"Usuario"},
 *     operationId="atualizarUsuario",
 *     security={
 *         {"bearerAuth": {}}
 *     },
 *     @OA\Parameter(
 *         name="co_usuario",
 *         in="path",
 *         description="Identificador do Usuário.",
 *         required=true,
 *         @OA\Schema(
 *             type="integer",
 *             format="int32",
 *         )
 *     ),
 *     @OA\Parameter(
 *         name="ds_senha",
 *         in="query",
 *         description="Senha do usuário",
 *         example="00000000000",
 *         required=false,
 *         @OA\Schema(
 *              type="string",
 *              maximum=1,
 *              minimum=10
 *         ),
 *     ),
 *     @OA\Parameter(
 *         name="dt_nascimento",
 *         in="query",
 *         description="Data de nascimento do usuário",
 *         example="2019-06-30",
 *         required=false,
 *     ),
 *     @OA\Parameter(
 *         name="no_nome",
 *         in="query",
 *         description="Nome do usuário",
 *         example="Usuário de teste",
 *         @OA\Schema(
 *              type="string",
 *              maximum=1,
 *              minimum=10
 *         ),
 *         required=false,
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Invalid user supplied"
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="User not found"
 *     ),
 * )
 *
 *  @OA\Delete(
 *          path="/api/conta/usuario/{co_usuario}",
 *          tags={"Usuario"},
 *          summary="Remove um usuário específico.",
 *          operationId="removerUsuario",
 *          @OA\Parameter(
 *              name="co_usuario",
 *              in="path",
 *              description="Identificador do Usuário.",
 *              required=true,
 *              @OA\Schema(
 *                  type="integer",
 *                  format="int32",
 *              )
 *          ),
 *          @OA\Response(
 *              response=405,
 *              description="Parametros inválidos"
 *          ),
 *          deprecated=false,
 *          security={
 *              {"bearerAuth": {}}
 *          },
 *          @OA\Response(
 *              response=200,
 *              description="Operação Realizada com Sucesso",
 *          ),
 *          @OA\Response(
 *              response=400,
 *              description="Dados inválidos"
 *          ),
 *          @OA\Response(
 *              response=401,
 *              description="É necessário estar autenticado para ter acesso a essa funcionalidade."
 *          ),
 *      )
 * )
 */

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
        ]]);
    }

    public function index() : \Illuminate\Http\JsonResponse
    {
        return $this->sendResponse(
            $this->usuarioService->obterTodos(),
            "Operação Realizada com Sucesso",
            Response::HTTP_OK
        );
    }

    public function show(UsuarioModel $usuario) : \Illuminate\Http\JsonResponse
    {
        return $this->sendResponse(
            $usuario->toArray(),
            "Operação Realizada com Sucesso",
            Response::HTTP_OK
        );
    }

    public function store(Request $request) : \Illuminate\Http\JsonResponse
    {
        return $this->sendResponse($this->usuarioService->cadastrar($request->all()),
            "Operação Realizada com Sucesso",
            Response::HTTP_CREATED
        );
    }

    public function update(Request $request, $co_usuario)
    {
        return $this->sendResponse(
            $this->usuarioService->atualizar($request, $co_usuario),
            "Operação Realizada com Sucesso",
            Response::HTTP_OK
        );
    }

    public function destroy(UsuarioModel $usuario)
    {
        $this->usuarioService->remover($usuario);

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }

    /**
     * @todo Criar no swagger
     */
    public function alterarSenha(Request $request, $co_usuario)
    {
        return $this->sendResponse(
            $this->usuarioService->alterarSenha($request, $co_usuario),
            "Operação Realizada com Sucesso",
            Response::HTTP_OK
        );
    }
}
