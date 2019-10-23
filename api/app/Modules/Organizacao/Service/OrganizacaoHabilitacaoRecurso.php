<?php

namespace App\Modules\Organizacao\Service;

use App\Core\Service\AbstractService;
use App\Modules\Organizacao\Mail\Organizacao\CadastroOrganizacaoHabilitacaoRecursoSucesso;
use \App\Modules\Organizacao\Model\OrganizacaoHabilitacaoRecurso as OrganizacaoHabilitacaoRecursoModel;
use App\Modules\Core\Exceptions\EParametrosInvalidos;
use App\Modules\Organizacao\Model\OrganizacaoHabilitacaoHistorico;
use App\Modules\Upload\Model\Arquivo;
use App\Modules\Upload\Service\Upload;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class OrganizacaoHabilitacaoRecurso extends AbstractService
{
    public function __construct(OrganizacaoHabilitacaoRecursoModel $model)
    {
        parent::__construct($model);
    }

    public function alterarHabilitacaoRecurso($requestParams)
    {

        // echo print_r($requestParams->toArray());exit;
        try {
            DB::beginTransaction();
            $recurso = app(OrganizacaoHabilitacaoRecursoModel::class)->find($requestParams['co_organizacao_habilitacao_recurso']);
            $recurso->fill($requestParams->toArray());
            
            if(!empty($requestParams['anexo'])) {
                $recurso['co_arquivo'] = $this->salvarAnexoRecursoHabilitacaoAvaliacao($requestParams->file('anexo'));
            }

            $this->salvarHistoricoHabilitacao($recurso->toArray());
            
            $recurso->save();
            DB::commit();
        } catch (EParametrosInvalidos $exception) {
            DB::rollBack();
            throw $exception;
        }
    }

    private function salvarHistoricoHabilitacao($params)
    {
        $dadosUsuarioLogado = Auth::user()->dadosUsuarioAutenticado();
        $parametrosHistorico = [
            'co_organizacao' => $params['co_organizacao'],
            'st_avaliacao' => $params['st_parecer'],
            'ds_parecer' => $params['ds_parecer'],
            'dh_avaliacao' => new \DateTime($params['dh_cadastro_recurso']),
            'nu_nova_pontuacao' => $params['nu_pontuacao'],
            'co_usuario_avaliador' => $dadosUsuarioLogado['co_usuario']
        ];

        $historicoModel = app(OrganizacaoHabilitacaoHistorico::class);
        
        $historicoModel->fill($parametrosHistorico);
        $historicoModel->save();
    }

    private function salvarAnexoRecursoHabilitacaoAvaliacao($uploadedFile)
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
              'organizacao/habilitacao/avaliacao'
          );

        return $arquivoArmazenado->co_arquivo;
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
