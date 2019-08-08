<?php

namespace App\Modules\Pessoa\Model;


class Receita
{
    const SERVICO_PESSOA_FISICA = 'pessoa_fisica';
    const SERVICO_PESSOA_JURIDICA = 'pessoa_juridica';

    protected $receitaHost;
    protected $receitaUsuario;
    protected $receitaSenha;
    protected $urlBusca;
    public $resultadoConsulta;

    public function __construct(
        string $receitaHost,
        string $receitaUsuario,
        string $receitaSenha
    )
    {
        $this->receitaHost = $receitaHost;
        $this->receitaUsuario = $receitaUsuario;
        $this->receitaSenha = $receitaSenha;
    }

    public function obterReceitaHost()
    {
        return $this->receitaHost;
    }

    public function obterReceitaUsuario()
    {
        return $this->receitaUsuario;
    }

    public function obterReceitaSenha()
    {
        return $this->receitaSenha;
    }

    public function obterUrlBusca()
    {
        return $this->urlBusca;
    }

    public function obterDadosAutenticacao()
    {
        return $this->obterReceitaUsuario() . ':' . $this->obterReceitaSenha();
    }

    public function definirURLBusca(string $servico, string $identificador)
    {
        $this->urlBusca = $this->obterReceitaHost() . "/{$servico}/consultar/{$identificador}/basico";
        return $this->urlBusca;
    }

    public function converterResultadoParaArray()
    {
        if (empty($this->resultadoConsulta)) {
            throw new \Exception("Resultado não definido.");
        }

        $resultArray = json_decode(
            $this->resultadoConsulta,
            true
        );
        if (!is_array($resultArray)) {
            throw new \Exception("Não foi possível converter o resultado para Array.");
        }
        $this->resultadoConsulta = $resultArray;
    }
}
