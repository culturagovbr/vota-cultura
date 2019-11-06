<?php

namespace App\Modules\Conselho\Http\Resources;

use App\Modules\Conselho\Model\ConselhoIndicacaoHabilitacaoRecurso;
use Illuminate\Http\Resources\Json\JsonResource;

class ConselhoHabilitacaoIndicacaoRecurso extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'co_conselho_indicacao_habilitacao_recurso' => $this->co_conselho_indicacao_habilitacao_recurso,
            'co_conselho_indicacao_habilitacao' => $this->co_conselho_indicacao_habilitacao,
            'ds_recurso' => $this->ds_recurso,
            'st_parecer' => $this->st_parecer,
            'dh_cadastro_recurso' => $this->dh_cadastro_recurso->format('d/m/Y H:i:s'),
            'co_usuario_avaliador' => $this->co_usuario_avaliador,
            'indicacaoHabilitacao' => ConselhoIndicacaoHabilitacao::collection($this->indicacaoHabilitacao)
        ];
    }
}
