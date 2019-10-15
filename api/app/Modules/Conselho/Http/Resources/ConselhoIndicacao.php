<?php

namespace App\Modules\Conselho\Http\Resources;
use \App\Modules\Localidade\Http\Resources\Endereco;
use Illuminate\Http\Resources\Json\JsonResource;

class ConselhoIndicacao extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'co_conselho_indicacao' => $this->co_conselho_indicacao,
            'nu_cpf_indicado' => $this->nu_cpf_indicado,
            'no_indicado' => $this->no_indicado,
            'dh_indicacao' => $this->dh_indicacao,
            'endereco' => (new Endereco($this->endereco)),
            'conselho' => (new Conselho($this->conselho)),
            'arquivos' => ConselhoIndicacaoArquivo::collection($this->arquivos),
            'foto_indicado' => $this->fotoUsuario
        ];
    }
}
