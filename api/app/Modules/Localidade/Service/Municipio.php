<?php

namespace App\Modules\Localidade\Service;

use App\Core\Service\AbstractService;
use App\Modules\Localidade\Model\Municipio as MunicipioModel;

class Municipio extends AbstractService
{
    public function __construct(MunicipioModel $model)
    {
        parent::__construct($model);
    }
}
