<?php

namespace App\Modules\Organizacao\Service;

use App\Core\Service\AbstractService;
use App\Modules\Organizacao\Mail\Organizacao\CadastroOrganizacaoHabilitacaoRecursoSucesso;
use \App\Modules\Organizacao\Model\OrganizacaoHabilitacaoRecurso as OrganizacaoHabilitacaoRecursoModel;
use App\Modules\Core\Exceptions\EParametrosInvalidos;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class OrganizacaoHabilitacaoRecurso extends AbstractService
{
    public function __construct(OrganizacaoHabilitacaoRecursoModel $model)
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
            $coOrganizacao = $usuarioAutenticado['co_organizacao'];
            $dsRecurso = $requestParams['dsRecurso'];
            $dadosHabilitacaoRecurso = [];
            $dadosHabilitacaoRecurso['co_organizacao'] = $coOrganizacao;
            $dadosHabilitacaoRecurso['ds_recurso'] = $dsRecurso;
            $habilitacaoRecursoModel = $this->getModel();
            $habilitacaoRecursoModel->fill($dadosHabilitacaoRecurso);

            $habilitacaoRecursoModel->save();

            /** @var \App\Modules\Organizacao\Model\Organizacao $organizacao */
            $organizacao = app(\App\Modules\Organizacao\Model\Organizacao::class)->find($coOrganizacao);
            $this->enviarEmailConfirmacao($organizacao, $dsRecurso);
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
    private function enviarEmailConfirmacao(\App\Modules\Organizacao\Model\Organizacao $organizacao, string $dsRecurso) : void
    {
        $corpoEmail = $organizacao->toArray();
        $corpoEmail['ds_recurso'] = $dsRecurso;
        $corpoEmail['nu_cnpj'] = $organizacao->getCnpjFormatadoAttribute();
        $corpoEmail['representante'] = [
            'no_nome' => $organizacao->representante->no_nome,
            'ds_email' => $organizacao->representante->ds_email
        ];

        $corpoEmail['segmento']['ds_detalhamento'] = $organizacao->segmento->ds_detalhamento;

        Mail::to($organizacao->representante->ds_email)
            ->bcc($organizacao->ds_email)
            ->bcc(env('EMAIL_ACOMPANHAMENTO'))
            ->send(
                app()->make(CadastroOrganizacaoHabilitacaoRecursoSucesso::class, $corpoEmail)
            );
    }
}
