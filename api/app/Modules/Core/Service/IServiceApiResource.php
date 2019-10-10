<?php

namespace App\Core\Service;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

interface IServiceApiResource extends IService
{
    public function cadastrar(Collection $dados) : ?Model;

    public function obterUm($identificador) : ?Model;

    public function obterTodos() : ?Collection;

    public function atualizar(Request $request, int $identificador) :  ?array;

    public function remover(Request $request, int $identificador);

}
