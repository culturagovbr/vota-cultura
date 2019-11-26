<?php

namespace App\Modules\Organizacao\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class OrganizacaoIndicacao extends JsonResource
{
    public function toArray($request): array
    {
        $situacaoAvaliacao = 'Titular';

        if($this->tp_indicado === 's') {
            $situacaoAvaliacao = 'Suplente';
        }

        return [
            'co_organizacao_indicacao' => $this->co_organizacao_indicacao,
            'organizacao' => $this->organizacao,
            'segmento' => $this->organizacao->segmento,
            'nu_cpf_indicado' => $this->nu_cpf_indicado_formatado,
            'no_indicado' => $this->no_indicado,
            'tp_indicado' => $situacaoAvaliacao,
            'dt_nascimento_indicado' => $this->dt_nascimento_indicado_formatado,
            'ds_curriculo' => $this->ds_curriculo
        ];
    }
}
