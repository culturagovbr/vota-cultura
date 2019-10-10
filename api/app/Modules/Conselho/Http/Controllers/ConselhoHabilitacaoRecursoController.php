<?php

namespace App\Modules\Conselho\Http\Controllers;

use App\Modules\Conselho\Service\ConselhoHabilitacaoRecurso;
use App\Modules\Core\Exceptions\EMetodoIndisponivel;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;

class ConselhoHabilitacaoRecursoController extends Controller
{

    /**
     * @var ConselhoHabilitacaoRecurso
     */
    protected $service;

    public function __construct(ConselhoHabilitacaoRecurso $service)
    {
        $this->service = $service;
        $this->middleware('auth:api');
    }

    /**
     * @param Request $request
     * @throws EMetodoIndisponivel
     */
    public function store(Request $request)
    {
        throw new EMetodoIndisponivel('O prazo de envio do recurso da habilitação expirou.');
    }
}
