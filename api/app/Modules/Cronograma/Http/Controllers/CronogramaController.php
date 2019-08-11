<?php

namespace App\Modules\Cronograma\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Core\Http\Controllers\Traits\TApiResourceDestroy;
use App\Modules\Core\Http\Controllers\Traits\TApiResourceIndex;
use App\Modules\Core\Http\Controllers\Traits\TApiResourceUpdate;
use App\Modules\Cronograma\Service\Cronograma as CronogramaService;
use App\Modules\Cronograma\Model\Cronograma;

class CronogramaController extends Controller
{
    use TApiResourceIndex;

    /**
     * @var CronogramaService $service
     */
    protected $service;

    public function __construct(CronogramaService $service)
    {
        $this->service = $service;
    }
}
