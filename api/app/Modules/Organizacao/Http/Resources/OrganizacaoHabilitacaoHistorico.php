<?php

namespace App\Modules\Organizacao\Http\Resources;

use App\Modules\Conta\Http\Resources\Usuario;
use App\Modules\Core\Helper\CNPJ;
use App\Modules\Localidade\Http\Resources\Endereco;
use App\Modules\Representacao\Http\Resources\Representante;
use App\Modules\Representacao\Http\Resources\RepresentanteArquivoAvaliacao;
use Illuminate\Http\Resources\Json\JsonResource;

class OrganizacaoHabilitacaoHistorico extends JsonResource
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
            case \App\Modules\Organizacao\Model\OrganizacaoHabilitacao::SITUACAO_AVALIACAO_HABILITADA:
                $situacaoAvaliacao = 'Habilitada';
                break;
            default:
                $situacaoAvaliacao = '';
                break;
        }

        return [
            'co_organizacao_habilitacao_historico' => $this->co_organizacao_habilitacao_historico,
            'co_organizacao_habilitacao' => $this->co_organizacao_habilitacao,
            'co_organizacao' => $this->co_organizacao,
            'st_avaliacao' => $this->st_avaliacao,
            'ds_parecer' => $this->ds_parecer,
            'dh_avaliacao' => $this->dh_avaliacao,
            'nu_nova_pontuacao' => $this->nu_nova_pontuacao,
            'co_usuario_avaliador' => $this->co_usuario_avaliador,
            'st_revisao_final' => $this->st_revisao_final,
            'situacao_avaliacao' => $situacaoAvaliacao,
            'usuarioAvaliador' => (new Usuario($this->usuarioAvaliador)),
            'data_avaliacao_formatada' => $this->dh_avaliacao->format('d/m/Y h:i:s'),
        ];
    }
}
