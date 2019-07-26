<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

interface IServiceApiResource extends IService
{
    public function cadastrar(array $dados) : ?Model;

    public function obterUm($identificador) : ?Model;

    public function obterTodos() : ?Collection;

    public function atualizar(Request $request, int $identificador) : ?Model;

    public function remover(Request $request, Model $model);

}
