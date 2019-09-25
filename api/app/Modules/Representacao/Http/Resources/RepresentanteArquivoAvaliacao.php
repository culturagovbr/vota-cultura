<?php

namespace App\Modules\Representacao\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RepresentanteArquivoAvaliacao extends JsonResource
{
    public function toArray($request): array
    {

        return [
            'co_representante_arquivo_avaliacao' => $this->co_representante_arquivo_avaliacao,
            'co_representante_arquivo' => $this->co_representante_arquivo,
            'st_em_conformidade' => $this->st_em_conformidade,
            'ds_observacao' => $this->ds_observacao,
            'co_usuario_avaliador' => $this->co_usuario_avaliador,
            'dh_avaliacao' => $this->dh_avaliacao,
            'co_conselho_habilitacao' => $this->co_conselho_habilitacao,
            'representanteArquivo' => $this->representanteArquivo,
        ];
    }
}
