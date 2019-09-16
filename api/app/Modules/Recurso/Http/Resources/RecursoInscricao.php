<?php

namespace App\Modules\Recurso\Http\Resources;

use App\Modules\Conta\Http\Resources\Usuario as UsuarioResource;
use App\Modules\Fase\Http\Resources\Fase;
use Illuminate\Http\Resources\Json\JsonResource;

class RecursoInscricao extends JsonResource
{
    public function toArray($request): array
    {
        $usuario = NULL;
        if (!empty($this->usuario)) {
            $usuario = app(UsuarioResource::class, $this->usuario->toArray());
        }
        $fase = NULL;
        if (!empty($this->fase)) {
            $fase = app(Fase::class, $this->fase->toArray());
        }
        return [
            'co_recurso_inscricao' => $this->co_recurso_inscricao,
            'co_fase' => (string) $this->co_fase,
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
            'co_usuario_parecer' => $usuario,
            'fase' => $fase,
            'no_razao_social' => $this->no_razao_social,
            'no_representante' => $this->no_representante
        ];
    }


}
