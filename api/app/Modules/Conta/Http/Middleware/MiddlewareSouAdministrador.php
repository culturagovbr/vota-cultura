<?php

namespace App\Modules\Conta\Http\Middleware;

use App\Modules\Conta\Model\Perfil;
use App\Modules\Core\Exceptions\EParametrosInvalidos;
use Closure;
use Illuminate\Http\Request;

class MiddlewareSouAdministrador
{
    public function handle(Request $request, Closure $next)
    {
        $dadosUsuarioAutenticado = auth()->user()->dadosUsuarioAutenticado();
        if(empty($dadosUsuarioAutenticado)) {
            throw new EParametrosInvalidos('Usuário não autenticado.');
        }

        if ($dadosUsuarioAutenticado['perfil']->co_perfil !== Perfil::CODIGO_ADMINISTRADOR) {
            throw new EParametrosInvalidos('Funcionalidade indisponível para seu perfil.');
        }
        return $next($request);
    }
}
