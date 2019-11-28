<?php

namespace App\Modules\Conselho\Http\Resources;

use App\Modules\Conta\Http\Resources\Usuario;
use Illuminate\Http\Resources\Json\JsonResource;

class ConselhoIndicacaoHabilitacaoHistorico extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'co_conselho_indicacao_habilitacao_historico' => $this->co_conselho_indicacao_habilitacao_historico,
            'co_indicado' => $this->co_indicado,
            'st_avaliacao' => $this->st_avaliacao,
            'ds_parecer' => $this->ds_parecer,
            'dh_avaliacao' => $this->dh_avaliacao->format('d/m/Y H:i:s'),
            'co_usuario_avaliador' => $this->co_usuario_avaliador,
            'usuario_avaliador' => new Usuario($this->usuarioAvaliador)
        ];
    }
}
