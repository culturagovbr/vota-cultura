<?php

namespace App\Modules\Organizacao\Http\Controllers;

use App\Modules\Organizacao\Model\Criterio;
use App\Modules\Organizacao\Model\Organizacao;
use App\Modules\Organizacao\Service\Organizacao as OrganizacaoService;
use App\Modules\Core\Http\Controllers\AApiResourceController;
use App\Modules\Core\Http\Controllers\Traits\TApiResourceDestroy;
use App\Modules\Core\Http\Controllers\Traits\TApiResourceUpdate;

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
        throw new \Exception("Método não disponível");
    }

    public function index(): \Illuminate\Http\JsonResponse
    {
        throw new \Exception("Método não disponível");
    }
}
