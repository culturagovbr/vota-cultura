<?php

namespace App\Modules\Core\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Core\Service\IServiceApiResource;
use App\Modules\Core\Http\Controllers\Traits\TApiResourceIndex;
use App\Modules\Core\Http\Controllers\Traits\TApiResourceShow;
use App\Modules\Core\Http\Controllers\Traits\TApiResourceStore;

abstract class AApiResourceController extends Controller implements IApiResourceController
{
    use TApiResourceShow,
        TApiResourceIndex,
        TApiResourceStore;

    /**
     * @var IServiceApiResource
     */
    protected $service;

    public function __construct(IServiceApiResource $service)
    {
        $this->service = $service;
    }
}
