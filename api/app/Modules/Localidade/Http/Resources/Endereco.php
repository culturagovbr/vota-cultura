<?php

namespace App\Modules\Localidade\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Endereco extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'co_endereco' => $this->co_endereco,
            'ds_complemento' => $this->ds_complemento,
            'nu_cep' => $this->nu_cep,
            'ds_logradouro' => $this->ds_logradouro,
            'municipio' => (new Municipio($this->municipio)),
            'co_ibge' => $this->municipio->co_uf,
            'co_municipio' => $this->municipio->co_municipio,
        ];
    }
}
