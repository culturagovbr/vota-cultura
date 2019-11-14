<?php

namespace App\Modules\Conselho\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ConselhoVotacao extends JsonResource
{
    public function toArray($request): array
    {
        return array(
            'co_conselho_indicacao' => $this->co_conselho_indicacao,
            'no_indicado' => $this->no_indicado,
            'ds_curriculo' => $this->ds_curriculo,
            'no_uf' => $this->no_uf,
            'ds_localizacao' => asset($this->ds_localizacao),
            'dh_voto' => $this->dh_voto,
            'recebeu_meu_voto' => $this->recebeu_meu_voto,
        );
    }
}
