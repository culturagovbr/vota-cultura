<?php

namespace App\Modules\Organizacao\Http\Resources;

use App\Modules\Upload\Http\Resources\Arquivo;
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
            'ds_parecer' => $this->ds_parecer,
            'st_parecer' => $this->st_parecer,
            'st_avaliacao_final' => $this->st_avaliacao_final,
            'nu_pontuacao' => $this->nu_pontuacao,
            'arquivo' => $this->arquivo
        ];
    }
}
