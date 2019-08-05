<?php

namespace App\Modules\Localidade\Service;

use App\Core\Service\AbstractService;
use App\Modules\Localidade\Model\Municipio as MunicipioModel;
use Illuminate\Database\Eloquent\Collection;

class Municipio extends AbstractService
{
    public function __construct(MunicipioModel $model)
    {
        parent::__construct($model);
    }

    public function obterPorUF(int $identificador) : ?Collection
    {
        $municipios = $this->getModel()->where('co_uf', '=', $identificador)->get();
        return $municipios;
    }
}
