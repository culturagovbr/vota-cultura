<?php


namespace App\Modules\Organizacao\Mail\Organizacao;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CadastroDocumentacaoComprobatoriaComSucesso extends Mailable
{
    use Queueable,
        SerializesModels;

    public function build()
    {
        return $this->subject('Ministério da Cidadania - Documentação enviada com sucesso')
            ->view('organizacao::organizacao.email.cadastro-documentacao-comprobatoria-com-sucesso');
    }
}
