<?php

namespace App\Modules\Conselho\Service;

use App\Core\Service\AbstractService;
use App\Modules\Conselho\Mail\Conselho\CadastroIndicacaoHabilitacaoRecursoSucesso;
use App\Modules\Conselho\Model\ConselhoIndicacaoHabilitacaoRecursoHistorico;
use App\Modules\Core\Helper\CNPJ;
use App\Modules\Core\Helper\CPF;
use App\Modules\Localidade\Model\Endereco;
use App\Modules\Upload\Model\Arquivo;
use App\Modules\Upload\Service\Upload;
use Illuminate\Database\Eloquent\Model;
use App\Modules\Conselho\Model\ConselhoIndicacaoHabilitacaoRecurso as ConselhoIndicacaoHabilitacaoRecursoModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Modules\Core\Exceptions\EParametrosInvalidos;
use Illuminate\Support\Facades\Mail;

class ConselhoIndicacaoHabilitacaoRecurso extends AbstractService
{
    public function __construct(ConselhoIndicacaoHabilitacaoRecursoModel $model)
    {
        parent::__construct($model);
    }

    public function salvar($requestParams): ?Model
    {
        try {
            DB::beginTransaction();

            $dadosRecurso = $requestParams->only([
                'co_conselho_indicacao_habilitacao',
                'ds_recurso'
            ]);

            $dadosIndicado = $requestParams->only([
                'co_conselho_indicacao',
                'dt_nascimento_indicado',
                'endereco',
                'municipio',
                'uf',
                'ds_curriculo',
            ]);

            $dtNascimento = new \DateTime($dadosIndicado['dt_nascimento_indicado']);
            $dadosIndicado['dt_nascimento_indicado'] = $dtNascimento->format('Y-d-m');

            $conselhoIndicacao = $this->atualizarIndicado($dadosIndicado, $requestParams->file('anexo'));
            $dadosRetorno = $this->cadastrarRecurso($dadosRecurso);

            $conselho = app(\App\Modules\Conselho\Model\Conselho::class)->find($conselhoIndicacao->co_conselho);

            $this->enviarEmailIndicacaoHabilitacaoRecurso($conselho, $conselhoIndicacao, $dadosRecurso);

            DB::commit();
            return $dadosRetorno;
        } catch (EParametrosInvalidos $queryException) {
            DB::rollBack();
            throw $queryException;
        }
    }

    private function atualizarIndicado($dadosIndicado, $anexo)
    {
        $conselhoIndicacao = app(\App\Modules\Conselho\Model\ConselhoIndicacao::class)
            ->find($dadosIndicado['co_conselho_indicacao']);

        if ($anexo) {
            $dadosIndicado['co_arquivo'] = $this->atualizarFotoIndicado($anexo);
        }

        $conselhoIndicacao->fill($dadosIndicado);
        $this->atualizarEndereco($conselhoIndicacao->co_endereco, $dadosIndicado['endereco']);
        $conselhoIndicacao->save();
        return $conselhoIndicacao;
    }

    private function atualizarEndereco($coEndereco, $dadosEndereco)
    {
        $endereco = app(Endereco::class)->find($coEndereco);
        $endereco->fill($dadosEndereco);
        $endereco->save();
        return $endereco;
    }

    private function atualizarFotoIndicado($arquivo)
    {
        $modeloArquivo = app(Arquivo::class);

        $modeloUpload = [
            'no_arquivo' => $arquivo->getClientOriginalName(),
            'no_extensao' => $arquivo->getClientOriginalExtension(),
            'no_mime_type' => $arquivo->getClientMimeType(),
        ];

        $modeloArquivo->fill($modeloUpload);

        $serviceUpload = new Upload($modeloArquivo);

        $arquivoArmazenado = $serviceUpload->uploadArquivoCodificado(
            $arquivo,
            'conselho/indicado_foto_rosto'
        );

        return $arquivoArmazenado->co_arquivo;
    }

    private function cadastrarRecurso($dadosRecurso)
    {
            $usuarioAutenticado = Auth::user()->dadosUsuarioAutenticado();
            $dadosRecurso['co_usuario_avaliador'] = $usuarioAutenticado['co_usuario'];
            $conselhoIndicacaoHabilitacaoModel = $this->getModel()->fill($dadosRecurso);

            $conselhoIndicacaoHabilitacaoModel->save();
            $dadosRecurso['co_conselho_indicacao_habilitacao_recurso'] = $conselhoIndicacaoHabilitacaoModel->co_conselho_indicacao_habilitacao_recurso;
            $historicoModel = app(ConselhoIndicacaoHabilitacaoRecursoHistorico::class);
            $historicoModel->fill($dadosRecurso);
            $historicoModel->save();
            return $conselhoIndicacaoHabilitacaoModel;
    }

    private function enviarEmailIndicacaoHabilitacaoRecurso($dadosConselho, $dadosIndicado, $dadosRecurso)
    {
        $corpoEmail = [
            'no_conselho' => $dadosConselho->no_conselho,
            'nu_cnpj' => CNPJ::adicionarMascara($dadosConselho->nu_cnpj),
            'no_indicado' => $dadosIndicado->no_indicado,
            'nu_cpf_indicado' => CPF::adicionarMascara($dadosIndicado->nu_cpf_indicado),
            'ds_recurso' => $dadosRecurso['ds_recurso'],
            'no_orgao_gestor' => $dadosConselho->no_orgao_gestor
        ];

        Mail::to($dadosConselho->representante->ds_email)
            ->bcc($dadosConselho->ds_email)
            ->bcc(env('EMAIL_ACOMPANHAMENTO'))
            ->send(
                app()->make(CadastroIndicacaoHabilitacaoRecursoSucesso::class, $corpoEmail)
            );
    }
}
