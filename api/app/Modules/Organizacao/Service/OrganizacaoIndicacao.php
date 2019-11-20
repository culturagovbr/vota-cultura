<?php

namespace App\Modules\Organizacao\Service;

use App\Core\Service\AbstractService;

use App\Modules\Organizacao\Model\OrganizacaoIndicacao as OrganizacaoIndicacaoModel;

class OrganizacaoIndicacao extends AbstractService
{
    public function __construct(OrganizacaoIndicacaoModel $model)
    {
        parent::__construct($model);
    }
}
