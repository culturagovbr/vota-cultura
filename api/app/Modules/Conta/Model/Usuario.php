<?php

namespace App\Modules\Conta\Model;

use App\Modules\Conselho\Model\Conselho;
use App\Modules\Core\Exceptions\EParametrosInvalidos;
use App\Modules\Eleitor\Model\Eleitor;
use App\Modules\Organizacao\Model\Organizacao;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
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
        'co_perfil',
        'nu_cpf',
        'perfis',
    ];

    protected $hidden = [
        'ds_senha',
        'ds_codigo_ativacao',
        'pivot'
    ];

    public $timestamps = false;

    public function perfil()
    {
        return $this->hasOne(
            Perfil::class,
            'co_perfil',
            'co_perfil'
        );
    }

    public function organizacao()
    {
        return $this->hasOne(
            Organizacao::class,
            'co_usuario',
            'co_usuario'
        );
    }

    public function conselho()
    {
        return $this->hasOne(
            Conselho::class,
            'co_usuario',
            'co_usuario'
        );
    }

    public function eleitor()
    {
        return $this->hasOne(
            Eleitor::class,
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
        return [
            'user' => [
                'no_nome' => $this->no_nome,
                'ds_email' => $this->ds_email,
                'dh_cadastro' => $this->dh_cadastro->format('Y-m-d H:i:s'),
                'dh_ultima_atualizacao' => $this->dh_ultima_atualizacao->format('Y-m-d H:i:s'),
                'st_ativo' => $this->st_ativo,
                'nu_cpf' => $this->nu_cpf,
                'perfil' => $this->perfil,
                'co_usuario' => $this->co_usuario,
                'co_eleitor' => ($this->eleitor) ? $this->eleitor->co_eleitor : null,
                'co_conselho' => ($this->conselho) ? $this->conselho->co_conselho : null,
                'co_organizacao' => ($this->organizacao) ? $this->organizacao->co_organizacao : null,
            ]
        ];
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

    public function gerarCodigoAtivacao(): void
    {
        if (empty($this->ds_email)) {
            throw new EParametrosInvalidos("E-mail não definido.");
        }
        $this->ds_codigo_ativacao = $this->gerarCodigo($this->ds_email);
    }

    private function gerarCodigo(string $string): string
    {
        return sha1(mt_rand(1, 999) . time() . $string);
    }

    public function dadosUsuarioAutenticado(): array
    {
        $payload = Auth::payload();
        if (empty($payload)) {
            return [];
        }
        return (array)$payload->get('user');
    }
}
