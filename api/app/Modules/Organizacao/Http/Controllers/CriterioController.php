<?php

namespace App\Modules\Organizacao\Http\Controllers;

use App\Modules\Organizacao\Service\Criterio as CriterioService;
use App\Modules\Core\Http\Controllers\AApiResourceController;

class CriterioController extends AApiResourceController
{
    public function __construct(CriterioService $service)
    {
        parent::__construct($service);
    }
}
