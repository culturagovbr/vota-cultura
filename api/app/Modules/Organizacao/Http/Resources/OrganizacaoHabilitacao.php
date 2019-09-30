<?php

namespace App\Modules\Organizacao\Http\Resources;

use App\Modules\Conta\Http\Resources\Usuario;
use App\Modules\Core\Helper\CNPJ;
use App\Modules\Localidade\Http\Resources\Endereco;
use App\Modules\Representacao\Http\Resources\Representante;
use App\Modules\Representacao\Http\Resources\RepresentanteArquivoAvaliacao;
use Illuminate\Http\Resources\Json\JsonResource;

class OrganizacaoHabilitacao extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'co_organizacao_habilitacao' => $this->co_organizacao_habilitacao,
            'co_organizacao' => $this->co_organizacao,
            'st_avaliacao' => $this->st_avaliacao,
            'ds_parecer' => $this->ds_parecer,
            'nu_nova_pontuacao' => $this->nu_nova_pontuacao,
            'arquivosAvaliacao' => RepresentanteArquivoAvaliacao::collection($this->representanteArquivoAvaliacao),
        ];
    }
}
