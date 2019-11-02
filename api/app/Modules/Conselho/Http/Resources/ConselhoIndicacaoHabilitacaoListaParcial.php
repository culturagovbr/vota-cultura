<?php

namespace App\Modules\Conselho\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ConselhoIndicacaoHabilitacaoListaParcial extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'co_conselho_indicacao_habilitacao' => $this->co_conselho_indicacao_habilitacao,
            'co_indicado' => $this->co_indicado,
            'st_avaliacao' => (bool) $this->st_avaliacao,
        ];
    }
}
