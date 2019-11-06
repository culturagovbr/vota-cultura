<?php

namespace App\Modules\Conselho\Http\Controllers;

use App\Modules\Conselho\Service\ConselhoIndicacaoHabilitacaoRecurso as ConselhoIndicacaoHabilitacaoRecursoService;
use App\Modules\Core\Exceptions\EParametrosInvalidos;
use App\Modules\Core\Http\Controllers\AApiResourceController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

use Illuminate\Http\Response;

class ConselhoHabilitacaoIndicacaoRecursoApiResourceController extends AApiResourceController
{

    public function __construct(ConselhoIndicacaoHabilitacaoRecursoService $service)
    {
        $this->middleware('auth:api');
        return parent::__construct($service);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request): JsonResponse
    {
        throw new EParametrosInvalidos('O prazo de recurso expirou!');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id): JsonResponse
    {
        throw new EParametrosInvalidos('Método não implementado');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id): JsonResponse
    {
        throw new EParametrosInvalidos('Método não implementado');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id): JsonResponse
    {
        throw new EParametrosInvalidos('Método não implementado');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id): JsonResponse
    {
        throw new EParametrosInvalidos('Método não implementado');
    }
}
