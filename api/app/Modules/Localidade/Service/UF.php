<?php

namespace App\Modules\Localidade\Service;

use App\Core\Service\AbstractService;
use App\Modules\Localidade\Model\UF as UFModel;
use Illuminate\Support\Collection;

class UF extends AbstractService
{
    public function __construct(UFModel $model)
    {
        parent::__construct($model);
    }

    public function obterTodos() : ?Collection
    {
        return $this->getModel()->orderBy('no_uf', 'asc')->get();
    }
}
