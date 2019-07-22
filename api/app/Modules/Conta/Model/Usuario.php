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
        'dt_nascimento',
        'dt_cadastro',
        'dt_ultima_atualizacao',
    ];

    protected $fillable = [
        'no_cpf',
        'no_nome',
        'no_email',
        'dt_nascimento',
        'dt_cadastro',
        'dt_ultima_atualizacao',
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
                'no_nome' => $this->no_nome,
                'no_cpf' => $this->no_cpf,
                'no_email' => $this->no_email,
                'dt_nascimento' => $this->dt_nascimento->format('Y-m-d'),
                'dt_cadastro' => $this->dt_cadastro->format('Y-m-d H:i:s'),
                'dt_ultima_atualizacao' => $this->dt_ultima_atualizacao->format('Y-m-d H:i:s'),
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
