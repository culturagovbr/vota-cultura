<?php

namespace App\Modules\Representacao\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Representante extends JsonResource
{
    public function toArray($request): array
    {
        $arquivosAvaliados = [];
        if($this->arquivosAvaliados) {
            $arquivosAvaliados = $this->arquivosAvaliados;
        }

        return [
            'co_representante' => $this->co_representante,
            'ds_email' => $this->ds_email,
            'no_nome' => $this->no_nome,
            'nu_rg' => $this->nu_rg,
            'nu_cpf' => $this->nu_cpf,
            'nu_telefone' => $this->nu_telefone,
            'dh_cadastro' => $this->dh_cadastro,
            'arquivos' => $this->arquivos,
            'arquivosAvaliados' => RepresentanteArquivoAvaliacao::collection($arquivosAvaliados),
        ];
    }
}
