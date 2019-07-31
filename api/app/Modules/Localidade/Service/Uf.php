<?php

namespace App\Modules\Localidade\Service;

use App\Core\Service\AbstractService;
use App\Modules\Localidade\Model\Uf as UfModel;

class Uf extends AbstractService
{
    public function __construct(UfModel $model)
    {
        parent::__construct($model);
    }
}
