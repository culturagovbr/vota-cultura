<?php

namespace App\Modules\Upload\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Upload\Http\Resources\Upload;
use App\Modules\Upload\Service\Upload as UploadService;


class UploadController extends Controller
{

    /**
     * @var UploadService
     */
    protected $service;

    public function __construct(UploadService $service)
    {
        $this->service = $service;
        $this->middleware('auth:api');
    }


    public function show($identificador)
    {
        return $this->service->downloadArquivo((int) $identificador);
    }
}
