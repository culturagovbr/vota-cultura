<?php


namespace App\Modules\Conselho\Mail\Conselho;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CadastroIndicacaoHabilitacaoRecursoSucesso extends Mailable
{
    use Queueable,
        SerializesModels;

    protected $conselho;

    public function __construct(array $conselho)
    {
        $this->conselho = $conselho;
    }

    public function build()
    {
        return $this->subject('Ministério da Cidadania - Recurso enviado com sucesso')
            ->view('conselho::conselho.email.cadastro-indicacao-habilitacao-recurso-sucesso')
            ->with([
                'conselho' => $this->conselho,
            ]);
    }
}
