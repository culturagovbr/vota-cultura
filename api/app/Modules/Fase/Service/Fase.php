<?php

namespace App\Modules\Fase\Service;

use App\Core\Service\AbstractService;
use App\Modules\Fase\Model\Fase as FaseModel;

class Fase extends AbstractService
{
    public function __construct(FaseModel $model)
    {
        parent::__construct($model);
    }


    public function obterPorTipo(string $tipoFase) : ?FaseModel
    {
        return $this->model->where('tp_fase', '=', $tipoFase)->first();
    }
}
