<?php

namespace App\Modules\Conselho\Service;

use App\Core\Service\AbstractService;
use App\Modules\Conselho\Mail\Conselho\CadastroRecursoHabilitacaoSucesso;
use App\Modules\Conselho\Model\ConselhoRecursoHabilitacao as ConselhoRecursoHabilitacaoModel;
use App\Modules\Core\Exceptions\EParametrosInvalidos;
use App\Modules\Upload\Model\Arquivo;
use App\Modules\Upload\Service\Upload;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class ConselhoRecursoHabilitacao extends AbstractService
{
    public function __construct(ConselhoRecursoHabilitacaoModel $model)
    {
        parent::__construct($model);
    }

    /**
     * @param $requestParams
     * @return ConselhoRecursoHabilitacaoModel|\Illuminate\Database\Eloquent\Model
     * @throws EParametrosInvalidos
     */
    public function cadastrarRecursoHabilitacao($requestParams)
    {
        if (empty($requestParams['dsRecurso'])) {
            throw new EParametrosInvalidos('A descrição do recurso deve ser preenchida.');
        }

        try {
            $usuarioAutenticado = Auth::user()->dadosUsuarioAutenticado();
            $coConselho = $usuarioAutenticado['co_conselho'];
            $dsRecurso = $requestParams['dsRecurso'];
            $dadosRecursoHabilitacao = [];
            $dadosRecursoHabilitacao['co_conselho'] = $coConselho;
            $dadosRecursoHabilitacao['ds_recurso'] = $dsRecurso;

            if(!empty($requestParams['anexo'])) {
                $dadosRecursoHabilitacao['co_arquivo'] = $this->cadastrarAnexoRecursoHabilitacao($requestParams['anexo']);
            }
            $recursoHabilitacaoModel = $this->getModel();
            $recursoHabilitacaoModel->fill($dadosRecursoHabilitacao);

            $recursoHabilitacaoModel->save();

            /** @var \App\Modules\Conselho\Model\Conselho $conselhoModel */
            $conselho = app(\App\Modules\Conselho\Model\Conselho::class)->find($coConselho);
            $this->enviarEmailConfirmacao($conselho, $dsRecurso);

            return $recursoHabilitacaoModel;
        } catch(EParametrosInvalidos $exception) {
            throw $exception;
        }
    }

    /**
     * @param UploadedFile $uploadedFile
     * @return mixed
     * @throws \Exception
     */
    private function cadastrarAnexoRecursoHabilitacao(UploadedFile $uploadedFile)
    {
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
            'conselho/recurso-habilitacao'
        );

        return $arquivoArmazenado->co_arquivo;
    }

    private function enviarEmailConfirmacao(\App\Modules\Conselho\Model\Conselho $conselho, string $dsRecurso) : void
    {
        $corpoEmail = $conselho->toArray();
        $corpoEmail['ds_recurso'] = $dsRecurso;
        $corpoEmail['representante'] = [
            'no_nome' => $conselho->representante->no_nome,
            'ds_email' => $conselho->representante->ds_email
        ];

        Mail::to($conselho->representante->ds_email)
            ->bcc($conselho->ds_email)
            ->bcc(env('EMAIL_ACOMPANHAMENTO'))
            ->send(
                app()->make(CadastroRecursoHabilitacaoSucesso::class, $corpoEmail)
            );
    }
}
