<?php

namespace App\Modules\Representacao\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RepresentanteArquivo extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'co_arquivo' => $this->co_arquivo,
            'no_arquivo' => $this->no_arquivo,
            'ds_localizacao' => $this->ds_localizacao,
            'dh_insercao' => $this->dh_insercao,
            'no_extensao' => $this->no_extensao,
            'no_mime_type' => $this->no_mime_type,
            'tp_arquivo' => $this->rl_representante_arquivo->tp_arquivo,
            'tp_inscricao' => $this->rl_representante_arquivo->tp_inscricao,
            'co_representante_arquivo' => $this->rl_representante_arquivo->co_representante_arquivo,
        ];
    }
}
