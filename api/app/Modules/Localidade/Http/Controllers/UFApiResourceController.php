<?php

namespace App\Modules\Localidade\Http\Controllers;

use App\Modules\Localidade\Service\Uf as UfService;
use App\Modules\Core\Http\Controllers\AApiResourceController;

class UFApiResourceController extends AApiResourceController
{
    public function __construct(UfService $service)
    {
        parent::__construct($service);
    }
}
