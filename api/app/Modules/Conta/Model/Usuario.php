<?php

namespace App\Modules\Conta\Model;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Usuario extends Authenticatable implements JWTSubject
{
    use Notifiable;

    protected $table = 'tb_usuario';
    protected $primaryKey = 'co_usuario';

    protected $dates = [
        'dh_cadastro',
        'dh_ultima_atualizacao',
    ];

    protected $fillable = [
        'no_pessoa',
        'ds_email',
        'dh_cadastro',
        'dh_ultima_atualizacao',
        'st_ativo',
        'perfis',
    ];

    protected $hidden = [
        'ds_senha',
        'ds_codigo_ativacao',
        'pivot'
    ];

    public $timestamps = false;

    public function perfis()
    {
        return $this->belongsToMany(
            \App\Modules\Conta\Model\Perfil::class,
            'rl_usuario_perfil',
            'co_usuario',
            'co_perfil'
        );
    }

    public function organizacoes()
    {
        return $this->hasMany(
            \App\Modules\Organizacao\Model\Organizacao::class,
            'co_usuario',
            'co_usuario'
        );
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims(): array
    {
        $perfis = [];
        if(!is_null($this->perfis)) {
            $perfis = $this->perfis->toArray();
        }

        $dadosPayload = [
            'user' => [
                'co_usuario' => $this->co_usuario,
                'no_pessoa' => $this->no_pessoa,
                'ds_email' => $this->ds_email,
                'dh_cadastro' => $this->dh_cadastro->format('Localizacao-m-d H:i:s'),
                'dh_ultima_atualizacao' => $this->dh_ultima_atualizacao->format('Localizacao-m-d H:i:s'),
                'st_ativo' => $this->st_ativo,
                'perfis' => $perfis,
            ]

        ];

        return $dadosPayload;
    }

    public function setSenha($ds_senha)
    {
        $this->ds_senha = password_hash(
            $ds_senha,
            PASSWORD_DEFAULT
        );
        return $this;
    }

    public function validarSenha($ds_senha)
    {
        return password_verify($ds_senha, $this->ds_senha);
    }
}
