<?php

namespace App\Modules\Conta\Service;

use App\Core\Service\AbstractService;
use App\Modules\Conta\Model\Perfil as PerfilModel;
use Illuminate\Database\Eloquent\Collection;


class Perfil extends AbstractService
{
    public function __construct(PerfilModel $model)
    {
        parent::__construct($model);
    }

    public function obterTodosAtivos(): ?Collection
    {
        return $this->getModel()->where('st_ativo', TRUE)->get();
    }

}
