<?php

namespace App\Modules\Conselho\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ConselhoIndicacaoHabilitacao extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'co_conselho_indicacao_habilitacao' => $this->co_conselho_indicacao_habilitacao,
            'co_indicado' => $this->co_indicado,
            'st_avaliacao' => (bool) $this->st_avaliacao,
            'ds_parecer' => $this->ds_parecer,
            'dh_avaliacao' => $this->dh_avaliacao->format('d/m/Y H:i:s'),
            'co_usuario_avaliador' => $this->co_usuario_avaliador,
            'st_revisao_final' => $this->st_revisao_final,
        ];
    }
}
