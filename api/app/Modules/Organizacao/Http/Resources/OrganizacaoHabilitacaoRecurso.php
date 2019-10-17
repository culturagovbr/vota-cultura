<?php

namespace App\Modules\Organizacao\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrganizacaoHabilitacaoRecurso extends JsonResource
{
    public function toArray($request): array
    {

        return [
            'co_organizacao_habilitacao_recurso' => $this->co_organizacao_habilitacao_recurso,
            'co_organizacao' => $this->co_organizacao,
            'ds_recurso' => $this->ds_recurso,
            'dh_cadastro_recurso' => $this->dh_cadastro_recurso,
        ];
    }
}
