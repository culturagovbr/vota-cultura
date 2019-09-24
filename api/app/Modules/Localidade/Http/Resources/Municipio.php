<?php

namespace App\Modules\Localidade\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Municipio extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'co_municipio' => $this->co_municipio,
            'no_municipio' => $this->no_municipio,
            'uf' => (new UF($this->uf)),
        ];
    }
}
