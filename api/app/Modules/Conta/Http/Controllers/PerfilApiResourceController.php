<?php

namespace App\Modules\Conta\Http\Controllers;

use App\Modules\Conta\Service\Perfil as PerfilService;
use App\Modules\Core\Http\Controllers\AApiResourceController;
use Illuminate\Http\Response;


class PerfilApiResourceController extends AApiResourceController
{

    public function __construct(PerfilService $perfilService)
    {
        $this->perfilService = $perfilService;
        $this->middleware('auth:api', ['only' => [
            'index',
            'show',
        ]]);
        parent::__construct($perfilService);
    }

    public function index(): \Illuminate\Http\JsonResponse
    {
        return $this->sendResponse(
            $this->service->obterTodosAtivos(),
            "Operação realizada com sucesso",
            Response::HTTP_OK
        );
    }
}
