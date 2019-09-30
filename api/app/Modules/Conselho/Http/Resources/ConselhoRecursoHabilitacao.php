<?php

namespace App\Modules\Conselho\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ConselhoRecursoHabilitacao extends JsonResource
{
    public function toArray($request): array
    {
        
        return [
            'co_conselho_recurso_habilitacao' => $this->co_conselho_recurso_habilitacao,
            'co_conselho' => $this->co_conselho,
            'ds_recurso' => $this->ds_recurso,
            'anexo' => $this->anexoRecurso,
            'dh_cadastro_recurso' => $this->dh_cadastro_recurso,
        ];
    }
}
