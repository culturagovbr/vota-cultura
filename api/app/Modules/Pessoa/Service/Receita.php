<?php

namespace App\Modules\Pessoa\Service;

use App\Core\Service\IService;
use App\Modules\Pessoa\Model\Receita as ReceitaModel;

class Receita implements IService
{

    /**
     * @var ReceitaModel
     */
    protected $modelo;

    public function __construct(ReceitaModel $modelo)
    {
        $this->modelo = $modelo;
    }

    public function consultarDadosPessoaFisica(string $identificador)
    {
        return $this->buscarDados(
            ReceitaModel::SERVICO_PESSOA_FISICA,
            $identificador
        );
    }

    public function consultarDadosPessoaJuridica(string $identificador)
    {
        return $this->buscarDados(
            ReceitaModel::SERVICO_PESSOA_JURIDICA,
            $identificador
        );
    }

    protected function buscarDados(string $servico, string $identificador)
    {
        $this->modelo->definirURLBusca(
            $servico,
            $identificador
        );

        $curl = curl_init();
        curl_setopt(
            $curl,
            CURLOPT_URL,
            $this->modelo->obterUrlBusca()
        );
        curl_setopt(
            $curl,
            CURLOPT_HTTPAUTH,
            CURLAUTH_BASIC
        );
        curl_setopt(
            $curl,
            CURLOPT_USERPWD,
            $this->modelo->obterDadosAutenticacao()
        );
        curl_setopt(
            $curl,
            CURLOPT_RETURNTRANSFER,
            1
        );

        $respostaRequisicao = curl_exec($curl);
        curl_close($curl);

        $this->modelo->resultadoConsulta = $respostaRequisicao;
        $this->modelo->converterResultadoParaArray();
        return $this->modelo->resultadoConsulta;
    }
}
