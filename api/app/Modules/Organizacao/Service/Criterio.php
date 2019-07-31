<?php

namespace App\Modules\Organizacao\Service;

use App\Core\Service\AbstractService;
use App\Modules\Organizacao\Model\Criterio as CriterioModel;
use DB;

class Criterio extends AbstractService
{
    public function __construct(CriterioModel $model)
    {
        parent::__construct($model);
    }
}
