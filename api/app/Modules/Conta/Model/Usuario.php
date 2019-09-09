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

class Usuario extends AAutenticacao
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

    public function setSenha($ds_senha)
    {
        $this->ds_senha = password_hash(
            $ds_senha,
            PASSWORD_DEFAULT
        );
        return $this;
    }

    public function senhaValida($ds_senha)
    {
        return password_verify($ds_senha, $this->ds_senha);
    }

    public function gerarCodigoAtivacao(): void
    {
        if (empty($this->ds_email)) {
            throw new EParametrosInvalidos("E-mail não definido.");
        }
        $this->ds_codigo_ativacao = parent::gerarCodigo($this->ds_email);
    }

    public function dadosUsuarioAutenticado(): array
    {
        $payload = Auth::payload();
        if (empty($payload)) {
            return [];
        }
        return (array)$payload->get('user');
    }

    public function souAdministrador() : bool
    {
        return ($this->perfil->no_perfil === 'administrador');
    }
}
