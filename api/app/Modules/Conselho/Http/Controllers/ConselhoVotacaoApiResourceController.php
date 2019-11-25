<?php

namespace App\Modules\Conselho\Http\Controllers;

use App\Modules\Conselho\Service\ConselhoVotacao;
use App\Modules\Core\Exceptions\EMetodoIndisponivel;
use App\Modules\Core\Http\Controllers\AApiResourceController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ConselhoVotacaoApiResourceController extends AApiResourceController
{
    public function __construct(ConselhoVotacao $service)
    {
        $this->middleware('auth:api');
        return parent::__construct($service);
    }

    public function index(): JsonResponse
    {
        throw new EMetodoIndisponivel("Método indisponível.");
    }

    public function show(): JsonResponse
    {
        throw new EMetodoIndisponivel("Método indisponível.");
    }

    public function store(Request $request): JsonResponse
    {
        throw new EMetodoIndisponivel("Período de votação encerrado.");
    }

    public function update(): \Illuminate\Http\JsonResponse
    {
        throw new EMetodoIndisponivel("Método indisponível.");
    }

}
