<?php

namespace App\Modules\Eleitor\Http\Controllers;

use App\Modules\Eleitor\Http\Resources\Eleitor as EleitorResource;
use App\Modules\Core\Http\Controllers\AApiResourceController;
use App\Modules\Core\Http\Controllers\Traits\TApiResourceDestroy;
use App\Modules\Core\Http\Controllers\Traits\TApiResourceUpdate;
use App\Modules\Eleitor\Service\Eleitor as EleitorService;

class EleitorApiResourceController extends AApiResourceController
{
    use TApiResourceUpdate,
        TApiResourceDestroy;

    public function __construct(EleitorService $service)
    {
        return parent::__construct($service);
    }

    public function show($identificador): \Illuminate\Http\JsonResponse
    {
        $eleitor = $this->service->obterUm($identificador);
        if(!$eleitor) {
            throw new \Exception('Eleitor não encontrado');
        }

        if($eleitor->nu_cpf !== auth()->user()->nu_cpf) {
            throw new \Exception('O Eleitor precisa ser o mesmo que o usuário logado.');
        }
//parent::genericShow($eleitor)'
       return EleitorResource::collection($eleitor);
    }

    public function index(): \Illuminate\Http\JsonResponse
    {
        throw new \Exception("Método não disponível");
    }
}
