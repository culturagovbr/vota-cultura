<?php

namespace App\Modules\Pessoa\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Pessoa\Service\Receita as ReceitaService;
use Illuminate\Http\Response;


class ReceitaController extends Controller
{
    /**
     * @var ConselhoService
     */
    private $service;

    public function __construct(ReceitaService $service)
    {
        $this->service = $service;
    }

    public function consultarDadosPessoaJuridica(string $identificador)
    {
        return $this->sendResponse(
            $this->service->consultarDadosPessoaJuridica($identificador),
            "Operação realizada com sucesso",
            Response::HTTP_OK
        );
    }

    public function consultarDadosPessoaFisica(string $identificador)
    {
        return $this->sendResponse(
            $this->service->consultarDadosPessoaFisica($identificador),
            "Operação realizada com sucesso",
            Response::HTTP_OK
        );
    }
}
