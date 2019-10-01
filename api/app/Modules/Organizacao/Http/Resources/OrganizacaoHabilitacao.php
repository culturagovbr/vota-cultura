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

        switch ($this->st_avaliacao) {
            case \App\Modules\Organizacao\Model\OrganizacaoHabilitacao::SITUACAO_AVALIACAO_INABILITADA:
                $situacaoAvaliacao = 'Inabilitada';
                break;
            case \App\Modules\Organizacao\Model\OrganizacaoHabilitacao::SITUACAO_AVALIACAO_HABILITADA_CLASSIFICADA:
                $situacaoAvaliacao = 'Habilitada e classificada';
                break;
            case \App\Modules\Organizacao\Model\OrganizacaoHabilitacao::SITUACAO_AVALIACAO_HABILITADA_DESCLASSIFICADA:
                $situacaoAvaliacao = 'Habilitada e desclassificada';
                break;
            default:
                $situacaoAvaliacao = '';
                break;
        }

        return [
            'co_organizacao_habilitacao' => $this->co_organizacao_habilitacao,
            'co_organizacao' => $this->co_organizacao,
            'st_avaliacao' => $this->st_avaliacao,
            'ds_parecer' => $this->ds_parecer,
            'nu_nova_pontuacao' => $this->nu_nova_pontuacao,
            'arquivosAvaliacao' => RepresentanteArquivoAvaliacao::collection($this->representanteArquivoAvaliacao),
            'situacao_avaliacao' => $situacaoAvaliacao,
        ];
    }
}
