<?php

namespace App\Modules\Conta\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UsuarioSomenteLeitura extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'co_usuario' => $this->co_usuario,
            'no_nome' => $this->no_nome,
            'situacao' => ($this->st_ativo) ? 'Ativo' : 'Inativo',
            'ds_email' => $this->ds_email,
            'nu_cpf_formatado' => $this->nu_cpf_formatado,
        ];
    }
}
