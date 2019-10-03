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
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function cadastrarHabilitacaoRecurso($requestParams)
    {
        if (empty($requestParams['dsRecurso'])) {
            throw new EParametrosInvalidos('A descrição do recurso deve ser preenchida.');
        }

        try {
            DB::beginTransaction();
            $usuarioAutenticado = Auth::user()->dadosUsuarioAutenticado();
            $coConselho = $usuarioAutenticado['co_conselho'];
            $dsRecurso = $requestParams['dsRecurso'];
            $dadosHabilitacaoRecurso = [];
            $dadosHabilitacaoRecurso['co_conselho'] = $coConselho;
            $dadosHabilitacaoRecurso['ds_recurso'] = $dsRecurso;
            $habilitacaoRecursoModel = $this->getModel();
            $habilitacaoRecursoModel->fill($dadosHabilitacaoRecurso);

            $habilitacaoRecursoModel->save();

            /** @var \App\Modules\Conselho\Model\Conselho $conselhoModel */
            $conselho = app(\App\Modules\Conselho\Model\Conselho::class)->find($coConselho);
            $this->enviarEmailConfirmacao($conselho, $dsRecurso);
            DB::commit();
            return $habilitacaoRecursoModel;
        } catch(EParametrosInvalidos $exception) {
            DB::rollBack();
            throw $exception;
        }
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
