<?php

namespace App\Modules\Core\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Core\Services\IServiceApiResource;
use App\Modules\Core\Http\Controllers\Traits\TApiResourceIndex;
use App\Modules\Core\Http\Controllers\Traits\TApiResourceShow;
use App\Modules\Core\Http\Controllers\Traits\TApiResourceStore;

abstract class AApiResourceController extends Controller implements IApiResourceController
{
    use TApiResourceShow,
        TApiResourceIndex,
        TApiResourceStore;

    public function __construct(IServiceApiResource $service)
    {
        parent::__construct($service);
    }
}
