<?php

namespace App\Modules\Localidade\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Regiao extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'co_regiao' => $this->co_regiao,
            'no_regiao' => $this->no_regiao,
        ];
    }
}
