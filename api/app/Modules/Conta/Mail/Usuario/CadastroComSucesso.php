<?php


namespace App\Modules\Conta\Mail\Usuario;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Modules\Conta\Model\Usuario as UsuarioModel;

class CadastroComSucesso extends Mailable
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

        $linkAtivacao = env('WEB_APP_HOST')
            . "/conta/ativar-usuario/{$this->usuario->ds_codigo_ativacao}";
        return $this->subject('Ministério da Cidadania - Cadastro Realizado com sucesso')
            ->view('conta::usuario.email.cadastro-com-sucesso')
            ->with([
                'usuario' => $this->usuario,
                'linkAtivacao' => $linkAtivacao,
            ]);
    }
}
