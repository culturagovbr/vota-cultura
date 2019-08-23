<?php

namespace App\Modules\Conselho\Http\Resources;

use App\Modules\Conta\Http\Resources\Usuario;
use App\Modules\Localidade\Http\Resources\Endereco;
use App\Modules\Localidade\Http\Resources\UF;
use App\Modules\Representacao\Http\Resources\Representante;
use Illuminate\Http\Resources\Json\JsonResource;

class Eleitor extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'co_eleitor' => $this->co_eleitor,
            'nu_cpf' => $this->nu_cpf,
            'no_nome' => $this->no_nome,
            'nu_rg' => $this->nu_rg,
            'dt_nascimento' => $this->dt_nascimento,
            'st_estrangeiro' => $this->st_estrangeiro,
            'uf' => (new UF($this->uf)),
            'usuario' => (new Usuario($this->usuario)),
            'ds_email' => $this->ds_email,
            'dh_cadastro' => $this->dh_cadastro,
        ];
    }
}
