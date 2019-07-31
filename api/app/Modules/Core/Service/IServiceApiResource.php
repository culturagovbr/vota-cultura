<?php

namespace App\Core\Service;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;


interface IServiceApiResource extends IService
{
    public function cadastrar(array $dados) : ?Model;

    public function obterUm($identificador) : ?Model;

    public function obterTodos() : ?Collection;

    public function atualizar(Request $request, int $identificador) : ?Model;

    public function remover(Request $request, int $identificador);

}
