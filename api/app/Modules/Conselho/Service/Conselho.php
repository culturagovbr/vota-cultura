<?php

namespace App\Modules\Conselho\Service;

use App\Core\Service\AbstractService;
use App\Modules\Conselho\Mail\Conselho\CadastroComSucesso;
use App\Modules\Conselho\Model\Conselho as ConselhoModel;
use App\Modules\Core\Exceptions\EParametrosInvalidos;
use App\Modules\Core\Exceptions\EValidacaoCampo;
use App\Modules\Fase\Model\Fase as FaseModel;
use App\Modules\Fase\Service\Fase;
use App\Modules\Localidade\Service\Endereco;
use App\Modules\Representacao\Model\Representante as RepresentanteModel;
use App\Modules\Representacao\Service\Representante;
use App\Modules\Upload\Model\Arquivo;
use App\Modules\Upload\Service\Upload;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class Conselho extends AbstractService
{
    public function __construct(ConselhoModel $model)
    {
        parent::__construct($model);
    }

    public function cadastrar(Collection $dados): ?Model
    {
        try {
            DB::beginTransaction();
            $serviceFase = app()->make(Fase::class);
            $fase = $serviceFase->obterPorTipo(FaseModel::ABERTURA_INSCRICOES_CONSELHO);

            if ($fase->faseFinalizada() && !Auth::user()->souAdministrador()) {
                throw new EValidacaoCampo('O período de inscrição já foi encerrado.');
            }

            $anexos = $dados['anexos'];
            unset($dados['anexos']);

            $conselho = $this->getModel()->where(
                $dados->only([
                    'ds_email',
                    'no_orgao_gestor',
                    'nu_cnpj',
                ])->toArray()
            )->first();

            if ($conselho) {
                throw new EParametrosInvalidos(
                    'Conselho já cadastrado.',
                    Response::HTTP_NOT_ACCEPTABLE
                );
            }

            $serviceRepresentante = app(Representante::class);
            $representante = $serviceRepresentante->cadastrar(collect($dados['representante']));

            if (!$representante) {
                throw new EParametrosInvalidos('Não foi possível cadastrar o representante.');
            }

            $dados['co_representante'] = $representante->co_representante;
            $serviceEndereco = app(Endereco::class);
            $endereco = $serviceEndereco->cadastrar(collect($dados['endereco']));

            if (!$endereco) {
                throw new EParametrosInvalidos('Não foi possível cadastrar o endereço.');
            }

            $dados['co_endereco'] = $endereco->co_endereco;
            $conselhoCriado = parent::cadastrar($dados);

            foreach ($anexos as $dadosArquivo) {
                $modeloArquivo = app(Arquivo::class);
                $modeloArquivo->fill($dadosArquivo);
                $serviceUpload = new Upload($modeloArquivo);
                $arquivoArmazenado = $serviceUpload->uploadArquivoCodificadoBase64(
                    $dadosArquivo['arquivoCodificado'],
                    'conselho/' . $dadosArquivo['tp_arquivo']
                );
                $representante->arquivos()->attach(
                    $arquivoArmazenado->co_arquivo,
                    [
                        'tp_arquivo' => $dadosArquivo['tp_arquivo'],
                        'tp_inscricao' => RepresentanteModel::TIPO_INSCRICAO_CONSELHO
                    ]
                );
            }

            Mail::to($representante->ds_email)
                ->bcc(env('EMAIL_ACOMPANHAMENTO'))
                ->send(
                    app()->make(CadastroComSucesso::class, $conselhoCriado->toArray())
                );

            DB::commit();
            return $conselhoCriado;
        } catch (EParametrosInvalidos $queryException) {
            DB::rollBack();
            throw $queryException;
        }
    }

    public function obterUm($identificador): ?Model
    {
        $conselho = parent::obterUm($identificador);
        if (!$conselho) {
            throw new EParametrosInvalidos('Conselho não encontrado');
        }

        $usuarioAutenticado = Auth::user()->dadosUsuarioAutenticado();
        if ($conselho->co_conselho !== $usuarioAutenticado['co_conselho'] &&
            !($usuarioAutenticado['perfil']->no_perfil !== 'administrador' ||
                $usuarioAutenticado['perfil']->no_perfil !== 'avaliador')) {
            throw new EParametrosInvalidos('O Conselho precisa ser o mesmo que o usuário logado.');
        }

        return $conselho;
    }

    public function obterTodosParcialmenteHabilitados()
    {
        return $this->getModel()->has('conselhoHabilitacao')->get();
    }

    public function concluirIndicacao(Request $request, int $identificador): ?array
    {
        try {
            $modelPesquisada = $this->getModel()->find($identificador);
            if (!$modelPesquisada) {
                throw new \HttpException(
                    'Dados não encontrados.',
                    Response::HTTP_NOT_ACCEPTABLE
                );
            }
            DB::beginTransaction();
            $modelPesquisada->fill($request->all());
            $modelPesquisada->save();
            /** $conselhoIndicacaoService ConselhoIndicacao */
            $conselhoIndicacaoService = app(ConselhoIndicacao::class);
            $conselhoIndicacaoService->enviarEmailConfirmacaoConselhoIndicacao($modelPesquisada);
            DB::commit();
            // dd($request->all());
            return $modelPesquisada->toArray();
        } catch (\HttpException $queryException) {
            DB::rollBack();
            throw $queryException;
        }
    }
}
