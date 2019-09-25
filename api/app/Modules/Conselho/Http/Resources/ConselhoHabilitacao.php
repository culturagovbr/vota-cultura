<?php

namespace App\Modules\Conselho\Http\Resources;

use App\Modules\Conta\Http\Resources\Usuario;
use App\Modules\Core\Helper\CNPJ;
use App\Modules\Localidade\Http\Resources\Endereco;
use App\Modules\Representacao\Http\Resources\Representante;
use Illuminate\Http\Resources\Json\JsonResource;

class ConselhoHabilitacao extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'co_conselho_habilitacao' => $this->co_conselho_habilitacao,
            'co_conselho' => $this->co_conselho,
            'st_avaliacao' => $this->st_avaliacao,
            'ds_parecer' => $this->ds_parecer,
        ];
    }
}
