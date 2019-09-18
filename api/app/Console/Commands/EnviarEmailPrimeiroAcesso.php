<?php

namespace App\Console\Commands;

use App\Modules\Conselho\Model\Conselho;
use App\Modules\Conta\Mail\Usuario\CadastroPrimeiroAcesso;
use App\Modules\Organizacao\Http\Resources\Organizacao as OrganizacaoResource;
use App\Modules\Conselho\Http\Resources\Conselho as ConselhoResource;
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
        $organizacaoModel = app(Organizacao::class);
        $listaEmailsOrganizacao = $organizacaoModel
            ->with('representante')
            ->whereNull('co_usuario')->get();

        $conselhoModel = app(Conselho::class);
        $listaEmailsConselho = $conselhoModel
            ->with('representante')
            ->whereNull('co_usuario')->get();

        foreach ($listaEmailsConselho as $conselho) {
            Mail::to($conselho->ds_email)->send(
                new CadastroPrimeiroAcesso($conselho)
            );
        }

        foreach ($listaEmailsOrganizacao as $organizacao) {
            Mail::to($organizacao->ds_email)->send(
                new CadastroPrimeiroAcesso($organizacao)
            );
        }

    }
}
