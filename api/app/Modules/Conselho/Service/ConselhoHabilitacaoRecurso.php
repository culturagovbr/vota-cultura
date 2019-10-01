<?php

namespace App\Modules\Conselho\Service;

use App\Core\Service\AbstractService;
use App\Modules\Conselho\Mail\Conselho\CadastroHabilitacaoRecursoSucesso;
use App\Modules\Conselho\Model\ConselhoHabilitacaoRecurso as ConselhoHabilitacaoRecursoModel;
use App\Modules\Core\Exceptions\EParametrosInvalidos;
use App\Modules\Representacao\Model\Representante as RepresentanteModel;
use App\Modules\Upload\Model\Arquivo;
use App\Modules\Upload\Service\Upload;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class ConselhoHabilitacaoRecurso extends AbstractService
{
    public function __construct(ConselhoHabilitacaoRecursoModel $model)
    {
        parent::__construct($model);
    }

    /**
     * @param $requestParams
     * @return \Illuminate\Database\Eloquent\Model|null
     * @throws EParametrosInvalidos
     */
    public function cadastrarRecursoHabilitacao($requestParams)
    {
        if (empty($requestParams['dsRecurso'])) {
            throw new EParametrosInvalidos('A descrição do recurso deve ser preenchida.');
        }

        try {
            DB::beginTransaction();
            $usuarioAutenticado = Auth::user()->dadosUsuarioAutenticado();
            $coConselho = $usuarioAutenticado['co_conselho'];
            $dsRecurso = $requestParams['dsRecurso'];
            $dadosRecursoHabilitacao = [];
            $dadosRecursoHabilitacao['co_conselho'] = $coConselho;
            $dadosRecursoHabilitacao['ds_recurso'] = $dsRecurso;

            if(!empty($requestParams['anexo'])) {
                $dadosRecursoHabilitacao['co_arquivo'] =
                    $this->cadastrarAnexoRecursoHabilitacao($requestParams['anexo'], $usuarioAutenticado);
            }
            $recursoHabilitacaoModel = $this->getModel();
            $recursoHabilitacaoModel->fill($dadosRecursoHabilitacao);

            $recursoHabilitacaoModel->save();

            /** @var \App\Modules\Conselho\Model\Conselho $conselhoModel */
            $conselho = app(\App\Modules\Conselho\Model\Conselho::class)->find($coConselho);
            $this->enviarEmailConfirmacao($conselho, $dsRecurso);
            DB::commit();
            return $recursoHabilitacaoModel;
        } catch(EParametrosInvalidos $exception) {
            DB::rollBack();
            throw $exception;
        }
    }

    /**
     * @param UploadedFile $uploadedFile
     * @param $usuarioAutenticado
     * @return mixed
     * @throws \Exception
     */
    private function cadastrarAnexoRecursoHabilitacao(UploadedFile $uploadedFile, $usuarioAutenticado)
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

        $this->salvarRelacionamentoArquivoRepresentante($arquivoArmazenado, $usuarioAutenticado);
        return $arquivoArmazenado->co_arquivo;
    }

    /**
     * @param $arquivoArmazenado
     * @param $usuarioAutenticado
     */
    private function salvarRelacionamentoArquivoRepresentante($arquivoArmazenado, $usuarioAutenticado)
    {
        $representanteModel = app(RepresentanteModel::class);
        /** @var RepresentanteModel $representante */
        $representante = $representanteModel->where([
            'nu_cpf' => $usuarioAutenticado['nu_cpf']
        ])->first();
        $representante->arquivos()->attach(
            $arquivoArmazenado->co_arquivo,
            [
                'tp_arquivo' => 'recurso_habilitacao_conselho',
                'tp_inscricao' => RepresentanteModel::TIPO_INSCRICAO_CONSELHO
            ]
        );
    }

    /**
     * @param \App\Modules\Conselho\Model\Conselho $conselho
     * @param string $dsRecurso
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
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
                app()->make(CadastroHabilitacaoRecursoSucesso::class, $corpoEmail)
            );
    }
}
