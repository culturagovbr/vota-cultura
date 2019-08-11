<?php

namespace App\Modules\Cronograma\Service;

use App\Core\Service\AbstractService;
use App\Modules\Cronograma\Model\Cronograma as CronogramaModel;

class Cronograma extends AbstractService
{
    public function __construct(CronogramaModel $model)
    {
        parent::__construct($model);
    }

}
