<?php


namespace App\Modules\Conselho\Mail\Conselho;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Modules\Conselho\Model\Conselho as ConselhoModel;

class CadastroComSucesso extends Mailable
{
    use Queueable,
        SerializesModels;

    protected $conselho;

    public function __construct(ConselhoModel $conselho)
    {
        $this->conselho = $conselho;
    }

    public function build()
    {

        return $this->subject('Ministério da Cidadania - Inscrição realizada com sucesso')
            ->view('conselho::conselho.email.cadastro-com-sucesso')
            ->with([
                'conselho' => $this->conselho,
            ]);
    }
}
