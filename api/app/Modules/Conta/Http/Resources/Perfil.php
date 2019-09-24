<?php

namespace App\Modules\Conta\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Perfil extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'co_perfil' => $this->co_perfil,
            'no_perfil' => $this->no_perfil,
            'ds_perfil' => $this->ds_perfil,
            'st_ativo' => $this->st_ativo,
        ];
    }
}
