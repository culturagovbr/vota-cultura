<?php

namespace App\Modules\Organizacao\Services;

use App\Core\Services\AbstractService;
use App\Modules\Organizacao\Model\Criterio as CriterioModel;
use DB;

class Criterio extends AbstractService
{
    public function __construct(CriterioModel $model)
    {
        parent::__construct($model);
    }
}
