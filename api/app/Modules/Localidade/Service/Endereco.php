<?php

namespace App\Modules\Localidade\Service;

use App\Core\Service\AbstractService;
use App\Modules\Localidade\Model\Endereco as EnderecoModel;

class Endereco extends AbstractService
{
    public function __construct(EnderecoModel $model)
    {
        parent::__construct($model);
    }
}
