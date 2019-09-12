<?php

namespace App\Modules\Recurso\Http\Resources;

use App\Modules\Conta\Http\Resources\Usuario;
use Illuminate\Http\Resources\Json\JsonResource;

class RecursoInscricao extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'co_recurso_inscricao' => $this->co_recurso_inscricao,
            'co_fase' => $this->co_fase,
            'ds_email' => $this->ds_email,
            'nu_cnpj' => $this->nu_cnpj,
            'nu_cpf' => $this->nu_cpf,
            'nu_telefone' => $this->nu_telefone,
            'ds_recurso' => $this->ds_recurso,
            'dh_cadastro' => $this->dh_cadastro,
            'ds_parecer' => $this->ds_parecer,
            'dh_parecer' => $this->dh_parecer,
            'st_parecer' => $this->st_parecer,
            'cnpj_formatado' => $this->cnpj_formatado,
            'cpf_formatado' => $this->cpf_formatado,
            'telefone_formatado' => $this->telefone_formatado,
            'dh_cadastro_formatado' => $this->dh_cadastro_formatado,
            'dh_parecer_formatado' => $this->dh_parecer_formatado,
            'co_usuario_parecer' => app(Usuario::class, $this->usuario),
            'fase' => app(Fase::class, $this->fase),
        ];
    }


}
