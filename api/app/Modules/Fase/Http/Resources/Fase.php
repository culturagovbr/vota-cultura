<?php

namespace App\Modules\Fase\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Fase extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'co_fase' => $this->co_fase,
            'tp_fase' => $this->tp_fase,
            'dh_inicio' => $this->dh_inicio,
            'dh_fim' => $this->dh_fim,
            'ds_detalhamento' => $this->ds_detalhamento,
        ];
    }
}
