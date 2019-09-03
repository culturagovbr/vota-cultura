<?php

namespace App\Modules\Fase\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Core\Http\Controllers\Traits\TApiResourceIndex;
use App\Modules\Fase\Service\Fase as FaseService;

class FaseController extends Controller
{
    use TApiResourceIndex;

    /**
     * @var FaseService $service
     */
    protected $service;

    public function __construct(FaseService $service)
    {
        $this->service = $service;
    }
}
