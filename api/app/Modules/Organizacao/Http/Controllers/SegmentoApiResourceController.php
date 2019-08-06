<?php

namespace App\Modules\Organizacao\Http\Controllers;

use App\Modules\Organizacao\Service\Segmento as SegmentoService;
use App\Modules\Core\Http\Controllers\AApiResourceController;

class SegmentoApiResourceController extends AApiResourceController
{
    public function __construct(SegmentoService $service)
    {
        parent::__construct($service);
    }
}
