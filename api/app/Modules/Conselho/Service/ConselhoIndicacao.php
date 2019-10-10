<?php

namespace App\Modules\Conselho\Service;

use App\Core\Service\AbstractService;
use App\Modules\Conselho\Model\ConselhoIndicacao as ConselhoIndicacaoModel;
use App\Modules\Core\Exceptions\EParametrosInvalidos;
use App\Modules\Organizacao\Mail\Organizacao\CadastroConselhoIndicacaoSucesso;
use App\Modules\Representacao\Model\Representante as RepresentanteModel;
use App\Modules\Upload\Model\Arquivo;
use App\Modules\Upload\Service\Upload;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Response;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class ConselhoIndicacao extends AbstractService
{

    public function __construct(ConselhoIndicacaoModel $model)
    {
        parent::__construct($model);
    }

    public function cadastrar(Collection $dados): ?Model
    {
        try {
            DB::beginTransaction();
            $this->getModel()->fill($dados->only(['co_conselho', 'nu_cpf_indicado', 'ds_curriculo']));
            $quantidadeMaximaIndicadosExcedida = $this->getModel()->quantidadeMaximaIndicadosExcedida();

            if ($quantidadeMaximaIndicadosExcedida) {
                throw new EParametrosInvalidos('O conselho já atingiu o limite de indicados.');
            }

            $indicacaoJaCadastrada = $this->getModel()->indicacaoJaCadastrada();

            if ($indicacaoJaCadastrada) {
                throw new EParametrosInvalidos(
                    'O indicado já está cadastrado.',
                    Response::HTTP_NOT_ACCEPTABLE
                );
            }

            $conselhoUsuarioLogado = $this->recuperarDadosConselhoUsuarioLogado();

            $this->cadastrarArquivosIndicacao($dados->only('arquivo'), $conselhoUsuarioLogado);
            $this->enviarEmailConfirmacaoConselhoIndicacao($conselhoUsuarioLogado);

             $dadosCadastrados = parent::cadastrar($dados);
             DB::commit();
             return $dadosCadastrados;
        } catch (EParametrosInvalidos $queryException) {
            DB::rollBack();
            throw $queryException;
        }
    }

    private function cadastrarArquivosIndicacao($anexos, $conselho)
    {
        /** @var UploadedFile $uploadedFile */
        foreach($anexos as $uploadedFile) {
            $modeloUpload = [
                'no_arquivo'  => $uploadedFile->getClientOriginalName(),
                'no_extensao'  => $uploadedFile->getClientOriginalExtension(),
                'no_mime_type'  => $uploadedFile->getClientMimeType(),
            ];

            $modeloArquivo = app(Arquivo::class);
            $modeloArquivo->fill($modeloUpload);
            $serviceUpload = new Upload($modeloArquivo);

            $arquivoArmazenado = $serviceUpload->uploadArquivoCodificado(
                $uploadedFile,
                'conselho/indicacao/'
            );

            $this->salvarRelacionamentoConselhoIndicacaoArquivo($arquivoArmazenado, $conselho, $uploadedFile->tpArquivo);

        }
//        return $arquivoArmazenado->co_arquivo;
    }

    private function salvarRelacionamentoConselhoIndicacaoArquivo($arquivoArmazenado, $conselho)
    {
        $conselhoIndicacaoModel = app(ConselhoIndicacaoModel::class);
        /** @var ConselhoIndicacaoModel $conselhoIndicacao */
        $conselhoIndicacao = $conselhoIndicacaoModel->where([
            'co_conselho' => $conselho['co_conselho']
        ])->first();
        $conselhoIndicacao->arquivos()->attach(
            $arquivoArmazenado->co_arquivo,
            [
                'tp_arquivo' => 'recurso_habilitacao_conselho',
            ]
        );
    }

    private function enviarEmailConfirmacaoConselhoIndicacao(\App\Modules\Conselho\Model\Conselho $conselho)
    {
        Mail::to($conselho->representante->ds_email)
            ->bcc($conselho->ds_email)
            ->bcc(env('EMAIL_ACOMPANHAMENTO'))
            ->send(
                app()->make(CadastroConselhoIndicacaoSucesso::class, $conselho->toArray())
            );
    }

    private function recuperarDadosConselhoUsuarioLogado()
    {
        $usuarioAutenticado = Auth::user()->dadosUsuarioAutenticado();
        return $this->getModel()->where([
            'co_organizacao' => $usuarioAutenticado['co_conselho']
        ])->first();
    }
}
