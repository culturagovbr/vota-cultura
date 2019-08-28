<?php

namespace App\Modules\Eleitor\Http\Resources;

use App\Modules\Conta\Http\Resources\Usuario;
use App\Modules\Localidade\Http\Resources\UF;
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
            'dt_nascimento' => $this->dt_nascimento->format('d/m/Y'),
            'st_estrangeiro' => (int)$this->st_estrangeiro,
            'ds_email' => $this->ds_email,
            'dh_cadastro' => $this->dh_cadastro->format('d/m/Y H:i:s'),
            'co_ibge' => $this->co_ibge,
            'uf' => (new UF($this->uf)),
            'usuario' => (new Usuario($this->usuario)),
            'nacionalidade' => ($this->st_estrangeiro === true) ? 'Brasileiro' : 'Estrangeiro'
        ];
    }
}
