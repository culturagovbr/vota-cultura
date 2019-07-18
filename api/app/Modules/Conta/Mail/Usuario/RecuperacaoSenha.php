<?php


namespace App\Modules\Conta\Mail\Usuario;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Modules\Conta\Model\Usuario as UsuarioModel;

class RecuperacaoSenha extends Mailable
{
    use Queueable,
        SerializesModels;

    protected $usuario;

    public function __construct(UsuarioModel $usuario)
    {
        $this->usuario = $usuario;
    }

    public function build()
    {

        $linkAlteracao = env('WEB_APP_HOST')
            . "/conta/alterar-senha/{$this->usuario->ds_codigo_alteracao}";
        return $this->subject('Ministério da Cidadania - Esqueceu a Senha')
            ->view('conta::usuario.email.recuperacao-senha')
            ->with([
                'usuario' => $this->usuario,
                'linkAlteracao' => $linkAlteracao,
            ]);
    }
}
