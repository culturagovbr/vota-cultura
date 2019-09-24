<?php

namespace App\Modules\Fase\Service;

use App\Core\Service\AbstractService;
use App\Modules\Fase\Model\Fase as FaseModel;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

class Fase extends AbstractService
{
    public function __construct(FaseModel $model)
    {
        parent::__construct($model);
    }

    public function obterPorTipo(string $tipoFase): ?FaseModel
    {
        return $this->model->where('tp_fase', '=', $tipoFase)->first();
    }

    public function obterDisponiveis(): ?Collection
    {
        $horarioAtual = Carbon::now();
        return $this->getModel()->whereRaw(
            '? between dh_inicio and dh_fim',
            [
                $horarioAtual
            ]
        )->get();
    }
}
