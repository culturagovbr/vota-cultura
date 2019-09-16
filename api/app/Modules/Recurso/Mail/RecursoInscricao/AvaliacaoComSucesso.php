<?php


namespace App\Modules\Recurso\Mail\RecursoInscricao;

use App\Modules\Recurso\Model\RecursoInscricao as RecursoInscricaoModel;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AvaliacaoComSucesso extends Mailable
{
    use Queueable,
        SerializesModels;

    protected $recursoInscricao;

    public function __construct(RecursoInscricaoModel $recursoInscricao)
    {
        $this->recursoInscricao = $recursoInscricao;
    }

    public function build()
    {

        return $this->subject('Ministério da Cidadania - Avaliação do recurso da inscrição')
            ->view('recurso::email.recurso-inscricao.avaliacao-com-sucesso')
            ->with([
                'recursoInscricao' => $this->recursoInscricao,
            ]);
    }
}
