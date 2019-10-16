<?php

namespace App\Modules\Conselho\Service;

use App\Core\Service\AbstractService;
use App\Modules\Conselho\Model\ConselhoIndicacao as ConselhoIndicacaoModel;
use App\Modules\Core\Exceptions\EParametrosInvalidos;
use App\Modules\Conselho\Mail\Conselho\CadastroConselhoIndicacaoSucesso;
use App\Modules\Conselho\Model\ConselhoIndicacaoArquivo;
use App\Modules\Localidade\Service\Endereco;
use App\Modules\Upload\Model\Arquivo;
use App\Modules\Upload\Service\Upload;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class ConselhoIndicacao extends AbstractService
{
    public function __construct(ConselhoIndicacaoModel $model)
    {
        parent::__construct($model);
    }

    public function obterTodos() : ?Collection
    {
        $conselhoUsuarioLogado = $this->recuperarDadosConselhoUsuarioLogado();
        return $this->getModel()->where([
            'co_conselho' => $conselhoUsuarioLogado->co_conselho
        ])->get();
    }

    public function cadastrar(Collection $dados): ?Model
    {
       $this->validarIdadeMinimaIndicado($dados['dt_nascimento_indicado']);

        try {
            DB::beginTransaction();
            $conselhoUsuarioLogado = $this->recuperarDadosConselhoUsuarioLogado();

            $this->getModel()->fill($dados->only([
                'nu_cpf_indicado',
                'ds_curriculo',
                'dt_nascimento_indicado'
            ])->toArray());
            $this->getModel()->co_conselho = $conselhoUsuarioLogado->co_conselho;

            $this->validarQuantidadeMaximaIndicados();
            $this->validarIndicacaoJaCadastrada();

            $serviceEndereco = app(Endereco::class);
            $endereco = $serviceEndereco->cadastrar(collect($dados['endereco']));

            if (!$endereco) {
                throw new EParametrosInvalidos('Não foi possível cadastrar o endereço.');
            }

            $dados['co_endereco'] = $endereco->co_endereco;

            $modeloUpload = [
                'no_arquivo'  => $dados['indicado_foto_rosto']->getClientOriginalName(),
                'no_extensao'  => $dados['indicado_foto_rosto']->getClientOriginalExtension(),
                'no_mime_type'  => $dados['indicado_foto_rosto']->getClientMimeType(),
            ];

            $modeloArquivo = app(Arquivo::class);

            $modeloArquivo->fill($modeloUpload);

            $serviceUpload = new Upload($modeloArquivo);

            $arquivoArmazenado = $serviceUpload->uploadArquivoCodificado(
                $dados['indicado_foto_rosto'],
                'conselho/indicado_foto_rosto'
            );

            $dados['co_arquivo'] = $arquivoArmazenado->co_arquivo;

//            $this->cadastrarArquivosIndicacao($dados->only('anexos'), $conselhoUsuarioLogado);

//            $this->enviarEmailConfirmacaoConselhoIndicacao($conselhoUsuarioLogado);

             $dadosCadastrados = parent::cadastrar($dados);
             DB::commit();
             return $dadosCadastrados;
        } catch (EParametrosInvalidos $queryException) {
            DB::rollBack();
            throw $queryException;
        }
    }

    private function validarIndicacaoJaCadastrada()
    {
        $indicacaoJaCadastrada = $this->getModel()->indicacaoJaCadastrada();

        if ($indicacaoJaCadastrada) {
            throw new EParametrosInvalidos(
                'O indicado já está cadastrado.',
                Response::HTTP_NOT_ACCEPTABLE
            );
        }
    }

    private function validarQuantidadeMaximaIndicados()
    {
        $quantidadeMaximaIndicadosExcedida = $this->getModel()->quantidadeMaximaIndicadosExcedida();
        if ($quantidadeMaximaIndicadosExcedida) {
            throw new EParametrosInvalidos('O conselho já atingiu o limite de indicados.');
        }
    }

    private function validarIdadeMinimaIndicado($idadeIndicado)
    {
        $hoje = Carbon::now();
        $nascimentoIndicado = Carbon::create($idadeIndicado);

        if ($hoje->diff($nascimentoIndicado)->y < 18) {
            throw new EParametrosInvalidos('A idade mínima permitida é 18 anos.');
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

            $this->salvarRelacionamentoConselhoIndicacaoArquivo($arquivoArmazenado, $conselho, $uploadedFile->slug);

        }
//        return $arquivoArmazenado->co_arquivo;
    }

    private function salvarRelacionamentoConselhoIndicacaoArquivo($arquivoArmazenado, $conselho, $slugArquivo)
    {
        $conselhoIndicacaoModel = app(ConselhoIndicacaoModel::class);
        /** @var ConselhoIndicacaoModel $conselhoIndicacao */
        $conselhoIndicacao = $conselhoIndicacaoModel->where([
            'co_conselho' => $conselho['co_conselho']
        ])->first();
        $conselhoIndicacao->arquivos()->attach(
            $arquivoArmazenado->co_arquivo,
            [
                'tp_arquivo' => $slugArquivo,
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
        $modelConselho = app(\App\Modules\Conselho\Model\Conselho::class);
        return $modelConselho->where([
            'co_conselho' => $usuarioAutenticado['co_conselho']
        ])->first();
    }

    public function remover(Request $request, int $identificador)
    {
        try {
            $indicado = $this->obterUm($identificador);
            if (!$indicado) {
                throw new \HttpException(
                    'Dados não localizados.',
                    Response::HTTP_NOT_ACCEPTABLE
                );
            }

            $conselho = (new \App\Modules\Conselho\Model\Conselho())->find($indicado->co_conselho);
            if (!$conselho) {
                throw new EParametrosInvalidos('Conselho não encontrado');
            }

            $usuarioAutenticado = Auth::user()->dadosUsuarioAutenticado();
            if ($conselho->co_conselho !== $usuarioAutenticado['co_conselho']) {
                throw new EParametrosInvalidos('Você não possui permissão para realizar esta ação.');
            }

            

            DB::beginTransaction();
            $this->removerArquivosIndicacao($identificador);
            $indicado->delete();
            DB::commit();
        } catch (\HttpException $queryException) {
            DB::rollBack();
            throw $queryException;
        }
    }
    
    private function removerArquivosIndicacao($identificador)
    {
        $conselhoIndicacaoArquivoModel = app(ConselhoIndicacaoArquivo::class);
        $arquivosIndicacao = $conselhoIndicacaoArquivoModel->where(['co_conselho_indicacao' => $identificador]);
        $arquivoModel = app(Arquivo::class);
        foreach($arquivosIndicacao->get()->toArray() as $arquivoIndicacao) {
            $arquivo = $arquivoModel->find($arquivoIndicacao['co_arquivo'])->toArray();
            Storage::delete($arquivo['ds_localizacao']);
            $arquivo->delete();
        }
        $arquivosIndicacao->delete();
    }
}
