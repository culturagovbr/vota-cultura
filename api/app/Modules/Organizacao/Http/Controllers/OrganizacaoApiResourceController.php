<?php

namespace App\Modules\Organizacao\Http\Controllers;

use App\Modules\Core\Exceptions\EParametrosInvalidos;
use App\Modules\Core\Http\Controllers\AApiResourceController;
use App\Modules\Core\Http\Controllers\Traits\TApiResourceDestroy;
use App\Modules\Core\Http\Controllers\Traits\TApiResourceUpdate;
use App\Modules\Organizacao\Service\Organizacao as OrganizacaoService;

class OrganizacaoApiResourceController extends AApiResourceController
{
    use TApiResourceUpdate,
        TApiResourceDestroy;

    public function __construct(OrganizacaoService $service)
    {
        parent::__construct($service);
    }

    public function show($identificador): \Illuminate\Http\JsonResponse
    {
        throw new EParametrosInvalidos("Método não disponível");
    }

    public function index(): \Illuminate\Http\JsonResponse
    {
        throw new EParametrosInvalidos("Método não disponível");
    }
}
