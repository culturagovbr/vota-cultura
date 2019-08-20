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
        'no_nome',
        'st_ativo',
        'ds_email',
        'ds_senha',
        'dh_cadastro',
        'dh_ultima_atualizacao',
        'ds_codigo_ativacao',
        'ds_codigo_alteracao',
        'co_perfil',
        'nu_cpf',
        'perfis',
    ];

    protected $hidden = [
        'ds_senha',
        'ds_codigo_ativacao',
        'ds_codigo_alteracao',
        'pivot'
    ];

    public $timestamps = false;

//    public function perfis()
//    {
//        return $this->belongsToMany(
//            \App\Modules\Conta\Model\Perfil::class,
//            'rl_usuario_perfil',
//            'co_usuario',
//            'co_perfil'
//        );
//    }

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
                'no_nome' => $this->no_nome,
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

    public function gerarCodigoAtivacao() : void
    {
        if(empty($this->ds_email)) {
            throw new \Exception("E-mail não definido.");
        }
        $this->ds_codigo_ativacao = $this->gerarCodigo($this->ds_email);
    }

    public function gerarCodigoAlteracao() : void
    {
        if(empty($this->nu_cpf)) {
            throw new \Exception("E-mail não definido.");
        }
        $this->ds_codigo_alteracao = $this->gerarCodigo($this->nu_cpf);
    }

    private function gerarCodigo(string $string) : string
    {
        return sha1(mt_rand(1, 999) . time() . $string);
    }
}
