<?php

namespace App\Modules\Conselho\Service;

use App\Core\Service\AbstractService;
use App\Modules\Conselho\Mail\Conselho\CadastroConselhoIndicacaoSucesso;
use App\Modules\Conselho\Model\ConselhoIndicacao as ConselhoIndicacaoModel;
use App\Modules\Conselho\Model\ConselhoIndicacaoArquivo;
use App\Modules\Conta\Model\Perfil;
use App\Modules\Core\Exceptions\EParametrosInvalidos;
use App\Modules\Localidade\Service\Endereco;
use App\Modules\Upload\Model\Arquivo;
use App\Modules\Upload\Service\Upload;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
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

    public function obterTodos(): ?Collection
    {
        $conselhoUsuarioLogado = $this->recuperarDadosConselhoUsuarioLogado();

        $dadosUsuarioAutenticado = auth()->user()->dadosUsuarioAutenticado();

        if (
            empty($conselhoUsuarioLogado) &&
            ($dadosUsuarioAutenticado['perfil']->co_perfil === Perfil::CODIGO_ADMINISTRADOR ||
                $dadosUsuarioAutenticado['perfil']->co_perfil === Perfil::CODIGO_AVALIADOR)
        ) {
            return $this->getModel()->whereHas('conselho', function ($query) {
                $query->where('tb_conselho.st_indicacao', 'f');
            })->get();
        }

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
                'no_arquivo' => $dados['indicado_foto_rosto']->getClientOriginalName(),
                'no_extensao' => $dados['indicado_foto_rosto']->getClientOriginalExtension(),
                'no_mime_type' => $dados['indicado_foto_rosto']->getClientMimeType(),
            ];

            $modeloArquivo = app(Arquivo::class);

            $modeloArquivo->fill($modeloUpload);

            $serviceUpload = new Upload($modeloArquivo);

            $arquivoArmazenado = $serviceUpload->uploadArquivoCodificado(
                $dados['indicado_foto_rosto'],
                'conselho/indicado_foto_rosto'
            );

            $dados['co_arquivo'] = $arquivoArmazenado->co_arquivo;

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

    public function enviarEmailConfirmacaoConselhoIndicacao(\App\Modules\Conselho\Model\Conselho $conselho)
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

            $coArquivo = $indicado->co_arquivo;
            DB::beginTransaction();
            $this->removerArquivosIndicacao($identificador);
            $indicado->delete();
            $this->removerFotoUsuario($coArquivo);
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
        foreach ($arquivosIndicacao->get()->toArray() as $arquivoIndicacao) {
            $arquivo = $arquivoModel->find($arquivoIndicacao['co_arquivo']);
            Storage::delete($arquivo->toArray()['ds_localizacao']);
            $arquivo->delete();
        }
        $arquivosIndicacao->delete();
    }

    private function removerFotoUsuario($coArquivoFotoUsuario)
    {
        $arquivoModel = app(Arquivo::class);
        $fotoUsuario = $arquivoModel->find($coArquivoFotoUsuario);
        Storage::delete($fotoUsuario->toArray()['ds_localizacao']);
        $fotoUsuario->delete();
    }

    public function obterIndicadosPorRegiao(string $regiao)
    {
        $colunas = [
            'tb_conselho_indicacao.co_conselho_indicacao',
            'tb_conselho_indicacao.no_indicado',
            'tb_conselho_indicacao.ds_curriculo',
            'tb_uf.no_uf',
            'tb_arquivo.ds_localizacao',
            'tb_conselho_votacao.dh_voto',
            'tb_conselho_indicacao.nu_cpf_indicado'
        ];

        $usuario = auth()->user();

        if (!empty($usuario) && $usuario->dadosUsuarioAutenticado()['co_eleitor']) {
            $usuario = $usuario->dadosUsuarioAutenticado()['co_eleitor'];

            $colunas[] = DB::raw("(CASE WHEN tb_conselho_votacao.co_eleitor = $usuario THEN TRUE ELSE FALSE END) AS recebeu_meu_voto");
        }

        return $this->getModel()->select($colunas)
            ->join(
            'tb_endereco',
            'tb_endereco.co_endereco',
            '=',
            'tb_conselho_indicacao.co_endereco')
            ->join(
                'tb_municipio',
                'tb_municipio.co_municipio',
                '=',
                'tb_endereco.co_municipio')
            ->join(
                'tb_uf',
                'tb_uf.co_ibge',
                '=',
                'tb_municipio.co_uf')
            ->join(
                'tb_regiao',
                'tb_regiao.co_regiao',
                '=',
                'tb_uf.co_regiao')
            ->join(
                'tb_conselho_indicacao_habilitacao',
                'tb_conselho_indicacao_habilitacao.co_indicado',
                '=',
                'tb_conselho_indicacao.co_conselho_indicacao')
            ->join(
                'tb_arquivo',
                'tb_arquivo.co_arquivo',
                '=',
                'tb_conselho_indicacao.co_arquivo'
            )

            ->leftJoin(DB::raw('(SELECT
                    max(tb_conselho_votacao.co_conselho_votacao) as co_votacao,
                    tb_conselho_votacao.co_conselho_indicacao
                FROM
                    tb_conselho_votacao
                GROUP BY
		            tb_conselho_votacao.co_conselho_indicacao) AS ultima_votacao'), function($join) {
                $join->on('ultima_votacao.co_conselho_indicacao', '=', 'tb_conselho_indicacao.co_conselho_indicacao');
            })
            ->leftJoin(
                'tb_conselho_votacao',
                'ultima_votacao.co_votacao',
                '=',
                'tb_conselho_votacao.co_conselho_votacao')
            ->where('tb_regiao.no_regiao', 'ILIKE', $regiao)
            ->where('tb_conselho_indicacao_habilitacao.st_avaliacao', '=', TRUE)
            ->distinct('nu_cpf_indicado')
            ->get();
    }

    public function possuiVoto()
    {
        $usuario = auth()->user();
        if (empty($usuario)) {
            return false;
        }
        $usuario = $usuario->dadosUsuarioAutenticado()['co_eleitor'];
        return (new \App\Modules\Conselho\Model\ConselhoVotacao())
            ->where('co_eleitor', '=', $usuario)
            ->first([DB::raw('
            CASE
                WHEN count(*) > 0 THEN TRUE
                ELSE FALSE
            END AS voto
            ')])->toArray()['voto'];
    }
}
