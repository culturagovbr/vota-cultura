<?php

namespace App\Modules\Organizacao\Http\Resources;

use App\Modules\Conta\Http\Resources\Usuario;
use App\Modules\Localidade\Http\Resources\Endereco;
use App\Modules\Representacao\Http\Resources\Representante;
use Illuminate\Http\Resources\Json\JsonResource;

class Criterio extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'co_criterio' => $this->co_criterio,
            'tp_criterio' => $this->tp_criterio,
            'ds_criterio' => $this->ds_criterio,
            'ds_detalhamento' => $this->ds_detalhamento,
            'qt_pontuacao' => $this->qt_pontuacao,
            'qt_peso' => $this->qt_peso,
        ];
    }
}
