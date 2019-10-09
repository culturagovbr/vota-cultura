<?php

namespace App\Modules\Conselho\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Conselho\Service\ConselhoHabilitacaoRecurso;
use App\Modules\Core\Exceptions\EMetodoIndisponivel;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ConselhoHabilitacaoRecursoController extends Controller
{
    protected $service;

    public function __construct(ConselhoHabilitacaoRecurso $service)
    {
        $this->service = $service;
        $this->middleware('auth:api');
    }

    public function store(Request $request): JsonResponse
    {
        throw new EMetodoIndisponivel('O prazo de envio do recurso da habilitação expirou.');
    }
}
