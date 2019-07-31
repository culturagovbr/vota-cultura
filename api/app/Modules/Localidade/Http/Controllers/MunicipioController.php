<?php

namespace App\Modules\Localidade\Http\Controllers;

use App\Modules\Localidade\Service\Municipio as MunicipioService;
use App\Modules\Core\Http\Controllers\AApiResourceController;

class MunicipioController extends AApiResourceController
{
    public function __construct(MunicipioService $service)
    {
        parent::__construct($service);
    }
}
