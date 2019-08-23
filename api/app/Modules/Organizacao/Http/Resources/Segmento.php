<?php

namespace App\Modules\Conselho\Http\Resources;

use App\Modules\Conta\Http\Resources\Usuario;
use App\Modules\Localidade\Http\Resources\Endereco;
use App\Modules\Representacao\Http\Resources\Representante;
use Illuminate\Http\Resources\Json\JsonResource;

class Segmento extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'co_segmento' => $this->co_segmento,
            'tp_segmento' => $this->tp_segmento,
            'ds_detalhamento' => $this->ds_detalhamento,
            'st_ativo' => $this->st_ativo,
        ];
    }
}
