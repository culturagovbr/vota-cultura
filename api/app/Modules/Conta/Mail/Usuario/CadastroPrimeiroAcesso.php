<?php


namespace App\Modules\Conta\Mail\Usuario;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CadastroPrimeiroAcesso extends Mailable
{
    use Queueable,
        SerializesModels;

    protected $dadosInscricao;

    public function __construct($dadosInscricao)
    {
        $this->dadosInscricao = $dadosInscricao;
    }

    public function build()
    {
        return $this->subject('Ministério da Cidadania - Acesso ao Vota Cultura')
            ->view('conta::usuario.email.cadastro-primeiro-acesso')
            ->with([
                'dadosInscricao' => $this->dadosInscricao
            ]);
    }
}
