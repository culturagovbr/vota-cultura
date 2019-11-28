<?php

namespace App\Modules\Conselho\Http\Resources;

use App\Modules\Conta\Http\Resources\Usuario;
use App\Modules\Localidade\Model\Endereco;
use Illuminate\Http\Resources\Json\JsonResource;

class ConselhoIndicacaoHabilitacao extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'co_conselho_indicacao_habilitacao' => $this->co_conselho_indicacao_habilitacao,
            'co_indicado' => $this->co_indicado,
            'st_avaliacao' => (bool) $this->st_avaliacao,
            'ds_parecer' => $this->ds_parecer,
            'dh_avaliacao' => $this->dh_avaliacao->format('d/m/Y H:i:s'),
            'co_usuario_avaliador' => $this->co_usuario_avaliador,
            'usuario_avaliador' => new Usuario($this->usuarioAvaliador),
            'st_revisao_final' => $this->st_revisao_final,
            'recurso' => $this->recurso,
            'indicado' => $this->indicado,
            'nu_cpf_formatado' => $this->indicado->cpf_indicado_formatado,
            'foto_indicado' => !empty($this->indicado->fotoUsuario->ds_localizacao) ?
                asset($this->indicado->fotoUsuario->ds_localizacao) : NULL,
            'conselho' => $this->indicado->conselho,
            'endereco' => new \App\Modules\Localidade\Http\Resources\Endereco($this->indicado->endereco)
        ];
    }
}
