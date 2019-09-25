<?php

namespace App\Modules\Conselho\Http\Resources;

use App\Modules\Conta\Http\Resources\Usuario;
use App\Modules\Core\Helper\CNPJ;
use App\Modules\Localidade\Http\Resources\Endereco;
use App\Modules\Representacao\Http\Resources\Representante;
use Illuminate\Http\Resources\Json\JsonResource;

class Conselho extends JsonResource
{
    public function toArray($request): array
    {
        return array(
            'co_conselho' => $this->co_conselho,
            'no_orgao_gestor' => $this->no_orgao_gestor,
            'no_conselho' => $this->no_conselho,
            'ds_email' => $this->ds_email,
            'nu_telefone' => $this->nu_telefone,
            'nu_cnpj' => $this->nu_cnpj,
            'nu_cnpj_mascarado' => CNPJ::adicionarMascara($this->nu_cnpj),
            'tp_governamental' => $this->tp_governamental,
            'endereco' => (new Endereco($this->endereco)),
            'representante' => (new Representante($this->representante)),
            'usuario' => (new Usuario($this->usuario)),
            'ds_sitio_eletronico' => $this->ds_sitio_eletronico,
            'st_inscricao' => $this->st_inscricao,
            'dh_cadastro' => $this->dh_cadastro,
            'habilitacao' => (new ConselhoHabilitacao($this->conselhoHabilitacao)),
        );
    }
}
