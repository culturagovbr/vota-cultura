<?php

namespace App\Modules\Conselho\Http\Resources;

use App\Modules\Localidade\Http\Resources\Endereco;
use Illuminate\Http\Resources\Json\JsonResource;

class ConselhoHabilitacaoListaFinal extends JsonResource
{
    public function toArray($request): array
    {
        return array(
            'co_conselho' => $this->co_conselho,
            'no_conselho' => $this->no_conselho,
            'nu_cnpj' => $this->nu_cnpj,
            'cnpj_formatado' => $this->cnpj_formatado,
            'tp_governamental' => $this->tp_governamental,
            'endereco' => (new Endereco($this->endereco)),
            'conselhoHabilitacao' => (new ConselhoHabilitacao($this->conselhoHabilitacao)),
        );
    }
}
