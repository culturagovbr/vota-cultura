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

    protected $fillable = [
        'no_cpf',
        'no_email',
        'dt_nascimento',
        'dt_cadastro',
        'dt_ultima_atualizacao',
        'st_ativo',
    ];

    protected $hidden = [
        'ds_senha',
        'ds_codigo_ativacao',
    ];

    protected $casts = [
    ];

    public $timestamps = false;

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims(): array
    {

        /**
         * @todo colocar aqui consulta para tabela de perfis
         * carregando os perfis que o usuário pode ter acesso.
         */

        $dadosPayload = [
            'cpf' => $this->no_cpf,
            'email' => $this->no_email,
            'dt_nascimento' => $this->dt_nascimento,
            'dt_cadastro' => $this->dt_cadastro,
            'dt_ultima_atualizacao' => $this->dt_ultima_atualizacao,
            'st_ativo' => $this->st_ativo,
        ];

        return $dadosPayload;
    }
}
