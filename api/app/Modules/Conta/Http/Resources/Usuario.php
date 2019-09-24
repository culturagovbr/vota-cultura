<?php

namespace App\Modules\Conta\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Usuario extends JsonResource
{
    public function toArray($request): array
    {

        return [
            'co_usuario' => $this->co_usuario,
            'no_nome' => $this->no_nome,
            'st_ativo' => $this->st_ativo,
            'situacao' => ($this->st_ativo) ? 'Ativo' : 'Inativo',
            'ds_email' => $this->ds_email,
            'dh_cadastro' => $this->dh_cadastro,
            'dh_ultima_atualizacao' => $this->dh_ultima_atualizacao,
            'ds_codigo_ativacao' => $this->ds_codigo_ativacao,
            'perfil' => $this->perfil,
            'nu_cpf' => $this->nu_cpf,
            'nu_cpf_formatado' => $this->nu_cpf_formatado,
        ];
    }
}
