<?php

namespace App\Modules\Conta\Model;

use App\Modules\Conselho\Model\Conselho;
use App\Modules\Core\Exceptions\EParametrosInvalidos;
use App\Modules\Core\Helper\CPF;
use App\Modules\Eleitor\Model\Eleitor;
use App\Modules\Organizacao\Model\Organizacao;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;

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
        'pivot'
    ];

    public $timestamps = FALSE;

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

    public function possoFazerDownload(): bool
    {
        $dadosUsuarioAutenticado = auth()->user()->dadosUsuarioAutenticado();
        if(empty($dadosUsuarioAutenticado)) {
            return false;
        }

        if ($dadosUsuarioAutenticado['perfil']->co_perfil !== Perfil::CODIGO_ADMINISTRADOR
            && $dadosUsuarioAutenticado['perfil']->co_perfil !== Perfil::CODIGO_AVALIADOR) {
            return false;
        }

        return true;
    }

    public function souAdministrador(): bool
    {
        $dadosUsuarioAutenticado = auth()->user()->dadosUsuarioAutenticado();
        $retorno = TRUE;

        if(empty($dadosUsuarioAutenticado)) {
            $retorno = FALSE;
        }

        if ($dadosUsuarioAutenticado['perfil']->co_perfil !== Perfil::CODIGO_ADMINISTRADOR) {
            $retorno = FALSE;
        }

        return $retorno;
    }

    public function getNuCpfFormatadoAttribute(): string
    {
        return CPF::adicionarMascara($this->nu_cpf);
    }

}
