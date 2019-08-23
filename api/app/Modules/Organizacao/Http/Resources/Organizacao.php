<?php

namespace App\Modules\Conselho\Http\Resources;

use App\Modules\Conta\Http\Resources\Usuario;
use App\Modules\Localidade\Http\Resources\Endereco;
use App\Modules\Representacao\Http\Resources\Representante;
use Illuminate\Http\Resources\Json\JsonResource;

class Organizacao extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'co_organizacao' => $this->co_organizacao,
            'nu_cnpj' => $this->nu_cnpj,
            'no_organizacao' => $this->no_organizacao,
            'ds_email' => $this->ds_email,
            'nu_telefone' => $this->nu_telefone,
            'segmento' => (new Segmento($this->segmento)),
            'usuario' => (new Usuario($this->usuario)),
            'endereco' => (new Endereco($this->segmento)),
            'representante' => (new Representante($this->representante)),
            'ds_sitio_eletronico' => $this->ds_sitio_eletronico,
            'st_inscricao' => $this->st_inscricao,
            'dh_cadastro' => $this->dh_cadastro,
        ];
    }
}
