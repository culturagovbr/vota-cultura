<?php

namespace App\Modules\Organizacao\Service;

use App\Core\Service\AbstractService;
use App\Modules\Core\Exceptions\EParametrosInvalidos;
use App\Modules\Core\Exceptions\EValidacaoCampo;
use App\Modules\Fase\Model\Fase;
use App\Modules\Fase\Model\Fase as FaseModel;
use App\Modules\Fase\Service\Fase as FaseService;
use App\Modules\Localidade\Service\Endereco;
use App\Modules\Organizacao\Mail\Organizacao\CadastroComSucesso;
use App\Modules\Organizacao\Mail\Organizacao\CadastroDocumentacaoComprobatoriaComSucesso;
use App\Modules\Organizacao\Model\Organizacao as OrganizacaoModel;
use App\Modules\Representacao\Model\Representante as RepresentanteModel;
use App\Modules\Representacao\Service\Representante;
use App\Modules\Upload\Model\Arquivo;
use App\Modules\Upload\Service\Upload;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class Organizacao extends AbstractService
{
    public function __construct(OrganizacaoModel $model)
    {
        parent::__construct($model);
    }

    public function cadastrar(Collection $dados): ?Model
    {
        try {
            DB::beginTransaction();

            $serviceFase = app()->make(FaseService::class);
            $fase = $serviceFase->obterPorTipo(FaseModel::ABERTURA_INSCRICOES_ORGANIZACAO);

            if ($fase->faseFinalizada() && !Auth::user()->souAdministrador()) {
                throw new EValidacaoCampo('O período de inscrição já foi encerrado.');
            }

            $organizacao = $this->getModel()->where(
                $dados->only([
                    'ds_email',
                    'no_organizacao',
                    'nu_cnpj',
                ])->toArray()
            )->first();

            if ($organizacao) {
                throw new EParametrosInvalidos(
                    'Organizacao já cadastrada.',
                    Response::HTTP_NOT_ACCEPTABLE
                );
            }

            $serviceRepresentante = app()->make(Representante::class);
            $representante = $serviceRepresentante->cadastrar(collect($dados['representante']));

            if (!$representante) {
                throw new EParametrosInvalidos('Não foi possível cadastrar o representante.');
            }
            $dados['co_representante'] = $representante->co_representante;

            $serviceEndereco = app()->make(Endereco::class);
            $endereco = $serviceEndereco->cadastrar(collect($dados['endereco']));

            if (!$endereco) {
                throw new EParametrosInvalidos('Não foi possível cadastrar o endereço.');
            }

            $dados['co_endereco'] = $endereco->co_endereco;
            $novaOrganizacao = parent::cadastrar($dados);

            foreach (array_values($dados['criterios']) as $criterioId) {
                $novaOrganizacao->criterios()->attach($criterioId);
            }

            Mail::to($representante->ds_email)
                ->bcc(env('EMAIL_ACOMPANHAMENTO'))
                ->send(
                    app()->make(CadastroComSucesso::class, $novaOrganizacao->toArray())
                );

            DB::commit();
            return $novaOrganizacao;
        } catch (EParametrosInvalidos $queryException) {
            DB::rollBack();
            throw $queryException;
        }
    }

    public function obterUm($identificador): ?Model
    {
        $organizacao = parent::obterUm($identificador);
        if (!$organizacao) {
            throw new EParametrosInvalidos('Organização não encontrado');
        }

        $usuarioAutenticado = Auth::user()->dadosUsuarioAutenticado();

        if ($organizacao->co_organizacao !== $usuarioAutenticado['co_organizacao'] &&
            $usuarioAutenticado['perfil']->no_perfil !== 'administrador' &&
            $usuarioAutenticado['perfil']->no_perfil !== 'avaliador') {
            throw new EParametrosInvalidos('A organização precisa ser o mesmo que o usuário logado.');
        }

        return $organizacao;
    }

    public function anexarDocumentacaoComprobatoria(
        string $slug,
        \Illuminate\Http\UploadedFile $uploadedFile,
        bool $enviarEmail = false
    ): ?Model
    {
        try {
            DB::beginTransaction();

            $usuarioAutenticado = Auth::user()->dadosUsuarioAutenticado();
            $organizacao = $this->getModel()->where([
                'co_organizacao' => $usuarioAutenticado['co_organizacao']
            ])->first();

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
                'organizacao/' . $slug
            );

            $organizacao->representante->arquivos()->attach(
                $arquivoArmazenado->co_arquivo,
                [
                    'tp_arquivo' => $slug,
                    'tp_inscricao' => RepresentanteModel::TIPO_DOCUMENTACAO_COMPROBATORIA_ORGANIZACAO
                ]
            );

            if ($enviarEmail === true) {
                Mail::to($organizacao->representante->ds_email)
                    ->bcc(env('EMAIL_ACOMPANHAMENTO'))
                    ->send(
                        app()->make(CadastroDocumentacaoComprobatoriaComSucesso::class, $organizacao->toArray())
                    );
            }

            DB::commit();
            return $organizacao;
        } catch (EParametrosInvalidos $queryException) {
            DB::rollBack();
            throw $queryException;
        }
    }

    public function obterDocumentacaoComprobatoria(int $identificador)
    {
        $organizacao = parent::obterUm($identificador);
        if (!$organizacao) {
            throw new EParametrosInvalidos('Organização não encontrado');
        }

        $usuarioAutenticado = Auth::user()->dadosUsuarioAutenticado();

        if ($organizacao->co_organizacao !== $usuarioAutenticado['co_organizacao'] &&
            $usuarioAutenticado['perfil']->no_perfil !== 'administrador') {
            throw new EParametrosInvalidos('A organização precisa ser do mesmo que o usuário logado.');
        }

        return $organizacao->representante->arquivos->where(
            'rl_representante_arquivo.tp_inscricao',
            RepresentanteModel::TIPO_DOCUMENTACAO_COMPROBATORIA_ORGANIZACAO
        );
    }
}
