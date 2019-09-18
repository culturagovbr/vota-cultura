<?php

namespace App\Console\Commands;

use App\Modules\Conselho\Model\Conselho;
use App\Modules\Conta\Mail\Usuario\CadastroPrimeiroAcesso;
use App\Modules\Eleitor\Model\Eleitor;
use App\Modules\Organizacao\Model\Organizacao;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class EnviarEmailPrimeiroAcesso extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:primeiro-acesso';


    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Solicitação de inscrições para primeiro acesso';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $organizacaoModel = app()->make(Organizacao::class);
        $listaEmailsOrganizacao = $organizacaoModel
            ->whereNull('co_usuario')->get()
            ->pluck('representante.ds_email')
            ->toArray();

        $conselhoModel = app()->make(Conselho::class);
        $listaEmailsConselho = $conselhoModel
            ->whereNull('co_usuario')->get()
            ->pluck('representante.ds_email')
            ->toArray();

        $listaEmailsGeral = array_merge(
            $listaEmailsConselho,
            $listaEmailsOrganizacao
        );

        foreach ($listaEmailsGeral as $email) {
            Mail::to($email)
                ->bcc(env('EMAIL_ACOMPANHAMENTO'))
                ->send(app()->make(CadastroPrimeiroAcesso::class));
        }

    }
}
