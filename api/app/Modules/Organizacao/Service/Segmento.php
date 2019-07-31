<?php

namespace App\Modules\Organizacao\Service;

use App\Core\Service\AbstractService;
use App\Modules\Organizacao\Model\Segmento as SegmentoModel;
use DB;

class Segmento extends AbstractService
{
    public function __construct(SegmentoModel $model)
    {
        parent::__construct($model);
    }


}
