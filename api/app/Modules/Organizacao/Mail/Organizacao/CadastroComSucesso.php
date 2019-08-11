<?php


namespace App\Modules\Organizacao\Mail\Organizacao;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Modules\Organizacao\Model\Organizacao as OrganizacaoModel;

class CadastroComSucesso extends Mailable
{
    use Queueable,
        SerializesModels;

    protected $organizacao;

    public function __construct(OrganizacaoModel $organizacao)
    {
        $this->organizacao = $organizacao;
    }

    public function build()
    {

        return $this->subject('Ministério da Cidadania - Inscrição realizada com sucesso')
            ->view('organizacao::organizacao.email.cadastro-com-sucesso')
            ->with([
                'organizacao' => $this->organizacao,
            ]);
    }
}
