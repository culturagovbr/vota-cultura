<?php


namespace App\Modules\Eleitor\Mail\Eleitor;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Modules\Eleitor\Model\Eleitor as EleitorModel;

class CadastroComSucesso extends Mailable
{
    use Queueable,
        SerializesModels;

    protected $eleitor;

    public function __construct(EleitorModel $eleitor)
    {
        $this->eleitor = $eleitor;
    }

    public function build()
    {

        return $this->subject('Ministério da Cidadania - Inscrição realizada com sucesso')
            ->view('eleitor::eleitor.email.cadastro-com-sucesso')
            ->with([
                'eleitor' => $this->eleitor,
            ]);
    }
}
