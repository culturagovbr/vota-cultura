<?php

namespace App\Modules\Localizacao\Service;

use App\Core\Service\AbstractService;
use App\Modules\Localizacao\Model\Endereco as EnderecoModel;
use DB;
use Illuminate\Database\Eloquent\Model;

class Endereco extends AbstractService
{
    public function __construct(EnderecoModel $model)
    {
        parent::__construct($model);
    }
}
