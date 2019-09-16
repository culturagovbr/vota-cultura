<?php

namespace App\Modules\Representacao\Service;

use App\Core\Service\AbstractService;
use App\Modules\Core\Exceptions\EParametrosInvalidos;
use App\Modules\Representacao\Model\Representante as RepresentanteModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class Representante extends AbstractService
{
    public function __construct(RepresentanteModel $model)
    {
        parent::__construct($model);
    }

    public function cadastrar(Collection $dados): ?Model
    {
        try {
            $representante = $this->getModel()->where(
                $dados->only([
                    'ds_email',
                    'nu_rg',
                    'nu_cpf',
                ])->toArray()
            )->first();

            if ($representante) {
                throw new EParametrosInvalidos(
                    'Representante já cadastrado.',
                    Response::HTTP_NOT_ACCEPTABLE
                );
            }

            return parent::cadastrar($dados);
        } catch (EParametrosInvalidos $queryException) {
            DB::rollBack();
            throw $queryException;
        } catch (\Exception $queryException) {
            DB::rollBack();
            throw $queryException;
        }
    }

}
