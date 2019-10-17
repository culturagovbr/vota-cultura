<?php


namespace App\Modules\Conselho\Mail\Conselho;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Modules\Conselho\Model\Conselho as ConselhoModel;

class CadastroConselhoIndicacaoSucesso extends Mailable
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
        return $this->subject('Ministério da Cidadania - Lista de indicados enviada com sucesso')
            ->view('conselho::conselho.email.cadastro-conselho-indicacao-sucesso')
            ->with([
                'conselho' => $this->conselho,
            ]);
    }
}
