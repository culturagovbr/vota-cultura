<?php

namespace App\Core\Services;

use Illuminate\Database\Eloquent\Model;

abstract class AbstractService implements IService
{
    private $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function getModel() : ?Model
    {
        return $this->model;
    }
}
