<?php

namespace App\Modules\Conta\Providers;

use App\Modules\Conta\Model\Usuario;
use Caffeinated\Modules\Support\ServiceProvider;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\UserProvider;

class AutenticacaoUserProvider implements UserProvider
{

    private $autenticado = false;

    /**
     * Retrieve a user by their unique identifier.
     *
     * @param  mixed $identifier
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function retrieveById($identifier)
    {
        $dadosUsuario = auth()->payload()->toArray();

        if(!empty($dadosUsuario['user'])) {
            return new Usuario((array)$dadosUsuario['user']);
        }
        return null;
    }

    /**
     * Retrieve a user by their unique identifier and "remember me" token.
     *
     * @param  mixed $identifier
     * @param  string $token
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function retrieveByToken($identifier, $token)
    {
        return auth()->user();
    }

    /**
     * Update the "remember me" token for the given user in storage.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable $user
     * @param  string $token
     * @return void
     */
    public function updateRememberToken(Authenticatable $user, $token)
    {
    }

    /**
     * Retrieve a user by the given credentials.
     *
     * @param  array $credentials
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function retrieveByCredentials(array $credentials)
    {
        $usuario = \App\Modules\Conta\Model\Usuario::where(
            'nu_cpf',
            $credentials['nu_cpf']
        )->first();

        if(!$usuario || $usuario->st_ativo === false) {
            return null;
        }

        $senhaCriptografada = $usuario->ds_senha;
        $usuarioValido = password_verify($credentials['ds_senha'], $senhaCriptografada);
        if(!$usuarioValido) {
            return null;
        }

        $this->autenticado = true;

        return $usuario;
    }

    /**
     * Validate a user against the given credentials.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable $user
     * @param  array $credentials
     * @return bool
     */
    public function validateCredentials(Authenticatable $user, array $credentials)
    {
        return $this->autenticado;
    }
}
