<?php

namespace App\Modules\Conselho\Http\Resources;
use \App\Modules\Localidade\Http\Resources\Endereco;
use Illuminate\Http\Resources\Json\JsonResource;

class ConselhoIndicacaoArquivo extends JsonResource
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
            'tp_arquivo' => $this->rl_conselho_indicacao_arquivo->tp_arquivo,
            'co_conselho_indicacao' => $this->rl_conselho_indicacao_arquivo->co_conselho_indicacao,
        ];
    }
}
