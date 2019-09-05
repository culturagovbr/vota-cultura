<?php

namespace App\Modules\Localidade\Service;

use App\Core\Service\AbstractService;
use App\Modules\Localidade\Model\Uf as UfModel;
use Illuminate\Support\Collection;

class Uf extends AbstractService
{
    public function __construct(UfModel $model)
    {
        parent::__construct($model);
    }

    public function obterTodos() : ?Collection
    {
        return $this->getModel()->orderBy('no_uf', 'asc')->get();
    }
}
