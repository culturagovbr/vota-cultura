<?php

namespace App\Modules\Localidade\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UF extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'co_ibge' => $this->co_ibge,
            'sg_uf' => $this->sg_uf,
            'no_uf' => $this->no_uf,
        ];
    }
}
