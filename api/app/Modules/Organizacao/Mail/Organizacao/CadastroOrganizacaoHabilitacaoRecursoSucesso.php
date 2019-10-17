<?php


namespace App\Modules\Organizacao\Mail\Organizacao;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CadastroOrganizacaoHabilitacaoRecursoSucesso extends Mailable
{
    use Queueable,
        SerializesModels;

    protected $organizacao;

    public function __construct(array $organizacao)
    {
        $this->organizacao = $organizacao;
    }

    public function build()
    {
        return $this->subject('Ministério da Cidadania - Recurso enviado com sucesso')
            ->view('organizacao::organizacao.email.cadastro-organizacao-recurso-habilitacao-sucesso')
            ->with([
                'organizacao' => $this->organizacao,
            ]);
    }
}
