<?php

namespace App\Modules\Organizacao\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

class OrganizacaoController extends Controller
{
    private $organizacaoService;

    public function __construct(OrganizacaoService $organizacaoService)
    {
        $this->organizacaoService = $organizacaoService;
    }

//    public function index() : \Illuminate\Http\JsonResponse
//    {
//        return $this->sendResponse(
//            $this->organizacaoService->obterTodos(),
//            "Operação Realizada com Sucesso",
//            Response::HTTP_OK
//        );
//    }
//
//    public function show(OrganizacaoModel $organizacao) : \Illuminate\Http\JsonResponse
//    {
//        return $this->sendResponse(
//            $organizacao->toArray(),
//            "Operação Realizada com Sucesso",
//            Response::HTTP_OK
//        );
//    }

    public function store(Request $request) : \Illuminate\Http\JsonResponse
    {
        return $this->sendResponse($this->organizacaoService->cadastrar($request->all()),
            "Operação Realizada com Sucesso",
            Response::HTTP_CREATED
        );
    }

//    public function update(Request $request, $co_organizacao)
//    {
//        return $this->sendResponse(
//            $this->organizacaoService->atualizar($request, $co_organizacao),
//            "Operação Realizada com Sucesso",
//            Response::HTTP_OK
//        );
//    }
//
//    public function destroy(OrganizacaoModel $organizacao)
//    {
//        $this->organizacaoService->remover($organizacao);
//
//        return response()->json(null, Response::HTTP_NO_CONTENT);
//    }
//
//    /**
//     * @todo Criar no swagger
//     */
//    public function alterarSenha(Request $request, $co_organizacao)
//    {
//        return $this->sendResponse(
//            $this->organizacaoService->alterarSenha($request, $co_organizacao),
//            "Operação Realizada com Sucesso",
//            Response::HTTP_OK
//        );
//    }
}
